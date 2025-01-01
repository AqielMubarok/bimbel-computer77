<?php

namespace App\Http\Controllers;

use App\Exports\PembayaranExport;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\PDF;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $pembayarans = DB::table('pembayarans')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.Pembayaran.index', compact('pembayarans'));
    }

    public function formBayar(Request $request)
{
    try {
        // Dekripsi data
        $decryptedData = json_decode(decrypt($request->input('data')), true);

        // Validasi keberadaan data
        if (!isset($decryptedData['paket'], $decryptedData['harga'], $decryptedData['hash'])) {
            return redirect()->route('pages.Pembayaran.paket')->with('error', 'Data tidak valid.');
        }

        // Validasi hash untuk memastikan integritas data
        $expectedHash = hash_hmac('sha256', "{$decryptedData['paket']}|{$decryptedData['harga']}", env('APP_KEY'));
        if ($decryptedData['hash'] !== $expectedHash) {
            return redirect()->route('pages.Pembayaran.paket')->with('error', 'Data telah dimanipulasi.');
        }

        // Validasi jenis paket dengan data yang ada di sistem
        $validPaket = ['Premium' => 1200000, 'Standar' => 500000];
        if (!array_key_exists($decryptedData['paket'], $validPaket) || $validPaket[$decryptedData['paket']] !== $decryptedData['harga']) {
            return redirect()->route('pages.Pembayaran.paket')->with('error', 'Jenis paket tidak sesuai.');
        }

        // Jika validasi berhasil, kirim data ke tampilan
        return view('pages.Pembayaran.formbayar', [
            'paket' => $decryptedData['paket'],
            'harga' => $decryptedData['harga'],
        ]);
    } catch (\Exception $e) {
        return redirect()->route('pages.Pembayaran.paket')->with('error', 'Terjadi kesalahan.');
    }
}

    public function storePembayaranRequest(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'jenis_paket' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'struk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Validasi ulang jenis paket dan harga
        $validPaket = ['Premium' => 1200000, 'Standar' => 500000];
        if (!array_key_exists($request->jenis_paket, $validPaket) || $validPaket[$request->jenis_paket] !== (int)$request->harga) {
            return back()->with('error', 'Data pembayaran tidak valid.');
        }

        $struk = $request->file('struk')->store('public/STRUK');

        Pembayaran::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'no_telp' => $validated['no_telp'],
            'email' => $validated['email'],
            'jenis_paket' => $validated['jenis_paket'],
            'harga' => $validated['harga'],
            'status' => 'pending',
            'tanggal_pembayaran' => now(),
            'struk' => basename($struk),
        ]);

        return redirect()->back()->with('success', 'Bukti telah terkirim. Silakan menunggu 1x24 Jam');
    }

    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $pembayaran = Pembayaran::findOrFail($id);
            return view('pages.Pembayaran.edit', compact('pembayaran'));
        } catch (\Exception $e) {
            return redirect()->route('pembayaran.index')->with('error', 'Data tidak valid.');
        }
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $user = $pembayaran->user;

        if ($request->status === 'Approved') {
            $user->update(['jenis_paket' => $pembayaran->jenis_paket]);
        } elseif ($request->status === 'Rejected') {
            $user->update(['jenis_paket' => null]);
        }

        $pembayaran->update(['status' => $request->status]);

        return redirect()->route('pembayaran.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        try {
            $user = $pembayaran->user;

            if ($user) {
                $user->update(['jenis_paket' => null]);
            }

            $pembayaran->delete();

            return redirect()->route('pembayaran.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('pembayaran.index')->with('error', 'Gagal menghapus data');
        }
    }

    public function export()
    {
        return Excel::download(new PembayaranExport, 'Pembayaran.xlsx');
    }

    public function printStruk($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $pdf = PDF::loadView('pdf.struk', ['pembayaran' => $pembayaran]);

        return $pdf->download('struk_pembayaran_' . $pembayaran->id . '.pdf');
    }

    public function history()
    {
        // Implementasi logika untuk menampilkan riwayat pembayaran dengan paginasi
        $pembayarans = Pembayaran::where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();  // Mempertahankan query string saat berpindah halaman

        return view('pages.Pembayaran.history', compact('pembayarans'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\nilai;
use App\Http\Requests\StoreNilaiRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Imports\NilaiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Crypt;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data user yang belum memiliki nilai
        $users = User::doesntHave('nilai') // Memastikan pengguna belum memiliki nilai
        ->where('rul', 'PESERTA') // Hanya peserta
        ->when($request->input('name'), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%'); // Pencarian berdasarkan nama
        })
        ->paginate(10); // Pagination untuk hasil

        return view('pages.nilai.index', compact('users'));
    }

    // Menampilkan form untuk membuat nilai
    public function create($encryptedId)
    {
        // Dekripsi ID yang terenkripsi
        $id = Crypt::decrypt($encryptedId);

        $user = User::findOrFail($id);
        return view('pages.nilai.create', compact('user'));
    }

    // Menyimpan data nilai
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nilai_tugas' => 'required',
            'nilai_ujian' => 'required',
            'predikat' => 'required',
            'kompetensi_unggulan' => 'required',
        ]);

        // Ambil nama user
        $user = User::findOrFail($request->user_id);

        // Tambahkan nama ke validated data
        $validatedData['name'] = $user->name;

        // Buat record nilai
        $nilai = new Nilai();
        $nilai->user_id = $request->user_id;
        $nilai->name = $user->name; // Tambahkan nama
        $nilai->nilai_tugas = $validatedData['nilai_tugas'];
        $nilai->nilai_ujian = $validatedData['nilai_ujian'];
        $nilai->predikat = $validatedData['predikat'];
        $nilai->kompetensi_unggulan = $validatedData['kompetensi_unggulan'];
        $nilai->save();
        return redirect()->route('nilai.index')->with('success', 'Data berhasil disimpan.');
    }

    public function lihatnilai(Request $request)
    {
        // Jika admin atau pemateri, tampilkan semua data nilai yang sudah ada
        if (auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI') {
            $nilais = DB::table('nilais')
                ->join('users', 'nilais.user_id', '=', 'users.id') // Menghubungkan tabel nilais dan users
                ->select('nilais.*', 'users.name') // Pilih kolom yang diperlukan
                ->when($request->input('name'), function ($query, $name) {
                    return $query->where('users.name', 'like', '%' . $name . '%'); // Pencarian berdasarkan nama
                })
                ->orderBy('nilais.id', 'desc')
                ->paginate(10);
        } else {
            // Untuk user biasa, hanya tampilkan data nilainya sendiri
            $nilais = DB::table('nilais')
                ->join('users', 'nilais.user_id', '=', 'users.id') // Menghubungkan tabel nilais dan users
                ->select('nilais.*', 'users.name') // Pilih kolom yang diperlukan
                ->where('nilais.user_id', auth()->id())
                ->when($request->input('name'), function ($query, $name) {
                    return $query->where('users.name', 'like', '%' . $name . '%'); // Pencarian berdasarkan nama
                })
                ->orderBy('nilais.id', 'desc')
                ->paginate(10);
        }

        return view('pages.nilai.indexnilai', compact('nilais'));
    }

    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $user = $nilai->user; // Asumsikan relasi Nilai ke User sudah dibuat
        return view('pages.nilai.create', compact('nilai', 'user')); // Gunakan view yang sama dengan create
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nilai_tugas' => 'required',
            'nilai_ujian' => 'required',
            'predikat' => 'required',
            'kompetensi_unggulan' => 'required',
        ]);
    
        $nilai = Nilai::findOrFail($id);

        $nilai->update($validatedData);
        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil diperbarui.');
    }

    // Mengunduh sertifikat dalam format PDF
    public function downloadCertificate($id)
    {
        $nilai = Nilai::findOrFail($id);

        // Generate PDF sertifikat
        $pdf = PDF::loadView('pdf.certificate', ['nilai' => $nilai]);

        // Mengirim PDF sebagai download
        return $pdf->download('sertifikat_nilai_' . $nilai->user->name . '.pdf');
    }

    // Menghapus nilai
    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->back()->with('success', 'Data nilai berhasil dihapus.');
    }
}

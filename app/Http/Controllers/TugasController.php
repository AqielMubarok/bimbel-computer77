<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreTugasRequest;
use App\Http\Requests\UpdateTugas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Tugas;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $tugas = DB::table('tugas')
            ->when($request->input('learning'), function ($query, $learning) {
                return $query->where('learning', 'like', '%' . $learning . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.Tugas.index', compact('tugas'));
    }

    public function create()
    {
        return view('pages.Tugas.create');
    }

    public function store(StoreTugasRequest $request)
    {
        // Validasi input
        $request->validate([
            'learning' => 'required|string|max:255',
            'lecturer' => 'required|string|max:255',
            'file' => 'required|file|mimes:doc,docx,pdf,xls,xlsx,ppt,pptx|max:2048', // Validasi tipe dan ukuran file
        ]);

        // Proses upload file
        if ($request->hasFile('file')) {
            $filename = $request->file('file')->getClientOriginalName();
            // Simpan file ke dalam folder 'public/tugas'
            $request->file('file')->storeAs('public/tugas', $filename);

            // Simpan data ke database menggunakan model
            Tugas::create([
                'learning' => $request->input('learning'),
                'lecturer' => $request->input('lecturer'),
                'file' => $filename, // Simpan nama file (bukan path lengkap)
            ]);

            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('tugas.index')->with('success', 'Tugas telah ditambahkan');
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }

    public function download($learning)
    {
        // Cari tugas berdasarkan learning
        $tugas = DB::table('tugas')->where('learning', $learning)->first();

        // Jika tugas tidak ditemukan, redirect dengan pesan error
        if (!$tugas) {
            return redirect()->route('tugas.index')->with('error', 'Tugas tidak ditemukan.');
        }

        // Dapatkan path file dari storage
        $filePath = storage_path('app/public/tugas/' . $tugas->file); // Perbaikan path

        // Periksa apakah file benar-benar ada
        if (!file_exists($filePath)) {
            return redirect()->route('tugas.index')->with('error', 'File tidak ditemukan di server.');
        }

        // Download file
        return response()->download($filePath, $tugas->file);
    }

    public function destroy($learning)
    {
        // Cari tugas berdasarkan ID
        $tugas = DB::table('tugas')->where('learning', $learning)->first();

        // Jika tugas tidak ditemukan, redirect dengan error
        if (!$tugas) {
            return redirect()->route('tugas.index')->with('error', 'Tugas tidak ditemukan.');
        }

        // Hapus tugas
        DB::table('tugas')->where('learning', $learning)->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }
    
    public function edit(Tugas $learning )
    {
        // Mencari tugas berdasarkan learning
        $tugas = DB::table('tugas')->where('learning', $learning)->first();
    
        // Jika tugas tidak ditemukan, redirect dengan pesan error
        if (!$tugas) {
            return redirect()->route('tugas.index')->with('error', 'Tugas tidak ditemukan.');
        }
    
        // Menampilkan form edit dengan data tugas yang ditemukan
        return view('pages.Tugas.edit', compact('tugas'));
    }

    public function update(UpdateTugas $request, Tugas $learning)
    {
    // Validasi input
    $request->validate([
        'learning' => 'required|string|max:255',
        'lecturer' => 'required|string|max:255',
        'file' => 'nullable|file|mimes:doc,docx,pdf,xls,xlsx,ppt,pptx|max:2048', // Validasi tipe dan ukuran file
    ]);

    // Mencari tugas berdasarkan learning
    $tugas = DB::table('tugas')->where('learning', $learning)->first();

    // Jika tugas tidak ditemukan, redirect dengan pesan error
    if (!$tugas) {
        return redirect()->route('tugas.index')->with('error', 'Tugas tidak ditemukan.');
    }

    // Proses mengupdate data
    $dataToUpdate = [
        'learning' => $request->input('learning'),
        'lecturer' => $request->input('lecturer'),
        'file' => $request->input('file'),
    ];

    // Proses upload file jika ada file baru
    if ($request->hasFile('file')) {
        $filename = $request->file('file')->getClientOriginalName();
        // Simpan file ke dalam folder 'public/tugas'
        $request->file('file')->storeAs('app/public/tugas', $filename);
        $dataToUpdate['file'] = $filename; // Update nama file
    }

    // Mengupdate data di database menggunakan model
    DB::table('tugas')->where('learning', $learning)->update($dataToUpdate);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diupdate.');
    }
}
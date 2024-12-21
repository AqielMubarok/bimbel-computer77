<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\KumpulTugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Storage;

class KumpulTugasController extends Controller
{
    public function index( Request $request)
    {
        $name = $request->input('name');
        $kelas = $request->input('kelas');
        $kumpul_tugas = DB::table('kumpul_tugas')
        ->when($request->input('name'), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })
        //->select('id', 'name', 'email', 'phone', DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as created_at'))
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('pages.Kumpul.index',compact('kumpul_tugas'));
    }

    public function create()
    {
        return view('pages.Kumpul.upload' );
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:2048', // Validasi file
        ]);

        // Upload file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->getClientOriginalName();
            // Simpan file ke dalam folder 'public/tugas'
            $request->file('file')->storeAs('public/tugas', $filePath);
        } else {
            // Jika tidak ada file yang diunggah, tampilkan error
            return redirect()->back()->with('error', 'File tidak ditemukan atau gagal diunggah.');
        }

        // Ambil user yang login
        $user = Auth::user();

        // Cari data kelas berdasarkan user
        $pembayaran = $user->pembayaran()->where('status', 'Approved')->first(); // Contoh dengan filter
        // Cek apakah data pembayaran ditemukan dan kolom jenis_paket tidak kosong
        if (!$pembayaran || !$pembayaran->jenis_paket) {
            // Jika tidak ada data pembayaran "Approved" atau kolom jenis_paket kosong
            return redirect()->back()->with('error', 'Anda belum memiliki pembayaran yang disetujui.');
        }

        // Ambil data 'jenis_paket' dari pembayaran
        $jenisPaket = $pembayaran->jenis_paket; // Hasilnya: "Premium" atau "Standar"

        // Simpan data ke tabel kumpul_tugas
        KumpulTugas::create([
            'name' => $user->name, // Nama user
            'judul_tugas' => $request->judul_tugas, // Judul tugas dari form
            'kelas' => $jenisPaket, // Isi kolom kelas dari jenis_paket
            'file' => $filePath, // Lokasi file yang diupload
            'tanggal_upload' => now(),

        ]);

        // Simpan file
        if ($request->hasFile('file')) {
            $filename = $request->file('file')->getClientOriginalName();
            // Simpan file ke dalam folder 'public/tugas'
            $request->file('file')->storeAs('public/tugas', $filename);
        
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Tugas Anda  Berhasil Dikumpulkan!');
    }
}
   
public function download($id)
{
    // Cari tugas berdasarkan id
    $kumpul_tugas = KumpulTugas::find($id);

    // Gunakan Storage facade untuk mengecek file
    if (!Storage::exists('public/tugas/' . $kumpul_tugas->file)) {
        return redirect()->route('kumpul.index')->with('error', 'File tidak ditemukan di server.');
    }

    // Download file dengan Storage facade
    return Storage::download('public/tugas/' . $kumpul_tugas->file);

    // Dapatkan path file dari storage
    $filePath = storage_path('app/public/tugas/' . $kumpul_tugas->file);

    // Periksa apakah file benar-benar ada
    if (!file_exists($filePath)) {
        return redirect()->route('kumpul.index')->with('error', 'File tidak ditemukan di server.');
    }

    // Download file
    return response()->download($filePath, $kumpul_tugas->file);
}
public function destroy($id)
{
    $tugas = KumpulTugas::find($id);
    
    if (!$tugas) {
        return redirect()->route('kumpul.index')->with('error', 'Tugas tidak ditemukan.');
    }

    // Tambahkan log sebelum menghapus
    Log::info('Menghapus tugas dengan ID: ' . $tugas->id);

    $tugas->delete();
    
    return redirect()->route('kumpul.index')->with('success', 'Data Anda berhasil dihapus.');
}

    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
  
}

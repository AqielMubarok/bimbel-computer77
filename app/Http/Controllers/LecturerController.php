<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLecturerRequest;
use App\Http\Requests\UpdateLecturer;
use App\Models\lecturer;
use Illuminate\Support\Facades\DB;

class LecturerController extends Controller
{
    public function index( Request $request)
    {
        $lecturers = DB::table('lecturers')
        ->when($request->input('judul_materi'), function ($query, $judul_materi) {
            return $query->where('judul_materi', 'like', '%' . $judul_materi . '%');
        })
        //->select('id', 'name', 'email', 'phone', DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as created_at'))
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('pages.pengajar.index', compact('lecturers'));
        dd($lecturers);
    }

    public function create()
    {
        return view('pages.pengajar.create' );
    }

    public function store(StoreLecturerRequest  $request)
    {
        lecturer::create([
            'name' => $request['name'],
            'position' => $request['position'],
            'materi' => $request['materi'],
            'judul_materi' => $request['judul_materi'],
            'jadwal' => $request['jadwal'],
        ]);
        return redirect()->route('lecturer.index')->with('success', 'Materi Pembelajaran telah ditambahkan.');
    }

    public function edit(Lecturer $lecturer)
    {
        // $user = \App\Models\User::findOrFail($id);
        return view('pages.pengajar.edit')->with('lecturer', $lecturer);
    }

    public function update(UpdateLecturer $request, Lecturer $lecturer)
    {
        $validate = $request->validated();
        $lecturer->update($validate);
        return redirect()->route('lecturer.index')->with('success', 'Data anda berhasil di ubah');
    }

    public function destroy(lecturer $lecturer)
    {
        $lecturer->delete();
        return redirect()->route('lecturer.index')->with('success', 'Data anda berhasil di hapus');
    }
}



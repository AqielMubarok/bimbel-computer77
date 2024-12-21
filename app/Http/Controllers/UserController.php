<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    {
        $users = DB::table('users')
        ->when($request->input('name'), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })
        //->select('id', 'name', 'email', 'phone', DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as created_at'))
        ->orderBy('id', 'desc')
        ->paginate(10);
        
        return view('pages.user.index' , compact('users'));
    }

    public function create()
    {
        return view('pages.user.create' );
    }

    public function store(StoreUserRequest $request)
    {
      //  User::add($request->all());
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'position' => $request['position'],
            'address' => $request['address'],
            'divisi' => $request['divisi'],
            'rul' => $request['rul'],
            'phone' => $request['phone'],
        ]);
        
       return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function edit($encryptedId)
    {
        // Dekripsi ID yang terenkripsi
        $id = Crypt::decrypt($encryptedId);
        
        // Ambil user berdasarkan ID yang sudah didekripsi
        $user = User::findOrFail($id);
        
        return view('pages.user.edit')->with('user', $user);
    }

    public function update(UpdateUserRequest $request, $encryptedId)
    {
        // Dekripsi ID
        $id = Crypt::decrypt($encryptedId);
        
        // Ambil user berdasarkan ID yang didekripsi
        $user = User::findOrFail($id);

        // Validasi dan update data user
        $validate = $request->validated();
        $user->update($validate);

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
       
       return redirect()->route('user.index')->with('success', 'Data anda berhasil di hapus');
    }
    
}

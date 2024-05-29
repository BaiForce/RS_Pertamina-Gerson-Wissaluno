<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\CommonHelpersTrait;


class UserController extends Controller
{
    use CommonHelpersTrait;

    public function index()
    {
        $users = User::where('id', '!=', 1)->get();
        $no = 1;
        return view('user.index', compact('users', 'no'));
    }

    public function edit($id)
    {
        $users = User::where('id', $id)->first();
        $no = 1;
        return view('user.edit', compact('users', 'no'));
    }

    public function store(Request $request)
    {
        try {

        $nameTerdaftar = User::where('name', $request->name)->exists();

        if ($nameTerdaftar) {
            return redirect()->back()->with('warning', 'Name ' . $request->name . ' Sudah Digunakan');
        }

        $emailTerdaftar = User::where('email', $request->email)->exists();

        if ($emailTerdaftar) {
            return redirect()->back()->with('warning', 'Email ' . $request->email . ' Sudah Digunakan');
        }

            $request->validate([
                'name' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'address' => 'required',
                'number' => 'required|numeric',
                'role' => 'required',
                'password' => 'required|min:8',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->number = $request->number;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);

            $user->save();

            return redirect()->route('user.index')->with('message', 'Data User yang Ditambahkan Telah Tersimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data User yang Ditambahkan Tidak Tersimpan');
        }
    }

    public function update(Request $request, $id)
{
    try {
        $user = User::findOrFail($id);

        $nameTerdaftar = User::where('name', $request->name)->whereNotIn('id', [$id]) // Exclude the current user's ID
            ->exists();

        if ($nameTerdaftar) {
            return redirect()->back()->with('warning', 'Nama ' . $request->name . ' Sudah Digunakan');
        }

        $emailTerdaftar = User::where('email', $request->email)
            ->whereNotIn('id', [$id])  // Exclude the current user's ID
            ->exists();

        if ($emailTerdaftar) {
            return redirect()->back()->with('warning', 'Email ' . $request->email . ' Sudah Digunakan');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'number' => 'required|numeric',
            'role' => 'required',
            'password' => 'nullable|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->number = $request->number;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('message', 'Data User yang Diubah Telah Tersimpan');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Data User yang Diubah Tidak Tersimpan');
    }
}



    public function delete(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('user.index')->with('message', 'message', 'Data User  yang Dihapus Telah Berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data User yang Dihapus Tidak Berhasil');
        }
    }
}

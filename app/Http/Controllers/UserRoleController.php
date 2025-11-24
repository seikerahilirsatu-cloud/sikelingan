<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->select('id','name','email','role','lingkungan')->orderBy('name')->get();
        $lingkunganOptions = config('data_keluarga_config.lingkungan', []);
        $roles = ['admin','staff','viewer','kepala_lingkungan'];
        return view('admin.users.index', compact('users','lingkunganOptions','roles'));
    }

    public function create()
    {
        $lingkunganOptions = config('data_keluarga_config.lingkungan', []);
        $roles = ['admin','staff','viewer','kepala_lingkungan'];
        return view('admin.users.create', compact('lingkunganOptions','roles'));
    }

    public function store(Request $request)
    {
        $roles = ['admin','staff','viewer','kepala_lingkungan'];
        $lingkunganOptions = config('data_keluarga_config.lingkungan', []);

        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => ['required','string', function($attr,$value,$fail) use ($roles){ if(!in_array($value,$roles)) $fail('Invalid role'); }],
            'lingkungan' => ['nullable','string', function($attr,$value,$fail) use ($lingkunganOptions){ if($value && !in_array($value,$lingkunganOptions)) $fail('Invalid lingkungan'); }]
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'lingkungan' => $request->input('lingkungan'),
        ]);

        return redirect()->route('admin.users.index')->with('success','User berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $roles = ['admin','staff','viewer','kepala_lingkungan'];
        $lingkunganOptions = config('data_keluarga_config.lingkungan', []);

        $request->validate([
            'role' => ['required','string', function($attr,$value,$fail) use ($roles){ if(!in_array($value,$roles)) $fail('Invalid role'); }],
            'lingkungan' => ['nullable','string', function($attr,$value,$fail) use ($lingkunganOptions){ if($value && !in_array($value,$lingkunganOptions)) $fail('Invalid lingkungan'); }]
        ]);

        DB::table('users')->where('id', $id)->update([
            'role' => $request->input('role'),
            'lingkungan' => $request->input('lingkungan'),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.users.index')->with('success','User diperbarui');
    }
}

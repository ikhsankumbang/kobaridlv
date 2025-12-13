<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Display login form
     */
    public function showLogin()
    {
        // If already logged in, redirect to home
        if (session('logged_in')) {
            return redirect('/home');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request
     * Using pegawai table like original kobarid app
     */
    public function login(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string',
            'id_pegawai' => 'required|string',
        ]);

        $nama_pegawai = $request->input('nama_pegawai');
        $id_pegawai = $request->input('id_pegawai');

        // Find user in pegawai table (matching original kobarid)
        $user = DB::table('pegawai')
            ->where('nama_pegawai', $nama_pegawai)
            ->where('id_pegawai', $id_pegawai)
            ->first();

        if ($user) {
            // Store user session
            session([
                'logged_in' => true,
                'id_pegawai' => $user->id_pegawai,
                'nama_pegawai' => $user->nama_pegawai,
                'jabatan' => $user->jabatan ?? null,
            ]);

            return redirect('/home');
        }

        return back()->withErrors(['login' => 'Nama pegawai atau ID pegawai salah!'])->withInput();
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        
        return redirect('/login');
    }
}

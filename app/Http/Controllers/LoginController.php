<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $cek = User::where('id', Auth()->user()->id)->firstOrFail();
            if ($cek->roles != "admin") {
                return response()->json([
                    'status' => 405,
                    'error' => 'Anda Tidak Memiliki Hak Akses'
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'success' => 'Anda Berhasil Login'
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'error' => 'Pastikan Anda Memasukkan Password Dengan Benar'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login.index'));
    }
}

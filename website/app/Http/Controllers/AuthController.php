<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
  public function showRegisterForm()
  {
    return view('auth.register');
  }

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'role' => 'required|in:patient,doctor,staff',
    ]);

    try {
        $response = Http::asJson()->post('http://api-gateway.local/api/login', [
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            session([
                'access_token' => $data['data']['access_token'],
                'user' => $data['data']['user'],
                'role' => $request->role,
            ]);

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => $response->json('error') ?? 'Đăng nhập thất bại',
        ])->withInput();

    } catch (\Exception $e) {
        return back()->withErrors([
            'email' => 'Lỗi kết nối tới máy chủ: ' . $e->getMessage(),
        ])->withInput();
    }
}


public function logout()
{
    session()->flush(); 
    return redirect()->route('login');
}

  public function showLoginForm()
  {
    return view('auth.login');
  }
}

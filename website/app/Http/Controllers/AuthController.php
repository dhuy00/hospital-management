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

    $role = $request->input('role');
    $email = $request->input('email');
    $password = $request->input('password');

    // Chọn API endpoint theo role
    $apiUrls = [
      'patient' => 'http://api-gateway.local/api/patient/login',
      'doctor' => 'http://api-gateway.local/api/doctor/login',
      'staff' => 'http://api-gateway.local/api/staff/login',
    ];

    $url = $apiUrls[$role];

    try {
      $response = Http::post($url, [
        'email' => $email,
        'password' => $password,
      ]);

      if ($response->successful()) {
        $data = $response->json();

        session(['access_token' => $data['access_token'], 'user' => $data['user']]);

        return redirect()->route('home');
      } else {
        return back()->withErrors([
          'email' => 'Sai email hoặc mật khẩu hoặc vai trò không hợp lệ',
        ])->withInput();
      }
    } catch (\Exception $e) {
      return back()->withErrors([
        'email' => 'Lỗi kết nối tới máy chủ: ' . $e->getMessage(),
      ])->withInput();
    }
  }

  public function logout()
  {
    Auth::logout();
    return redirect()->route('login');
  }

  public function showLoginForm()
  {
    return view('auth.login');
  }
}

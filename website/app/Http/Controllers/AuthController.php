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
  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
      'role' => 'required|in:patient,doctor,staff',
    ]);

    try {
      $response = Http::asJson()->post('http://localhost:8001/api/auth/login', [
        'email' => $request->email,
        'password' => $request->password,
        'role' => $request->role,
      ]);

      if ($response->successful()) {
        $data = $response->json();

        if ($request->role === 'patient') {
          $user = $data['data'];
        } else {
          $user = $data['data'][$request->role] ?? null;
        }

        $token = $data['data']['token'] ?? null;

        if (!$user || !$token) {
          return back()->withErrors([
            'email' => 'Dữ liệu trả về từ API không đầy đủ',
          ])->withInput();
        }

        session([
          'access_token' => $token,
          'user' => $user,
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

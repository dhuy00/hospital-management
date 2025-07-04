<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function showRegisterForm()
  {
    return view('auth.register');
  }

  public function register(Request $request)
  {
    // Validate dữ liệu nhập vào
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6|confirmed', // xác nhận với field password_confirmation
    ]);

    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }

    // Tạo user mới
    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => 'staff', 
    ]);


    return redirect()->route('login')->with('success', 'Đăng ký thành công!');
  }

  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      // Đăng nhập thành công
      return redirect()->route('home');
    }

    // Đăng nhập thất bại
    return back()->withErrors([
      'email' => 'Sai email hoặc mật khẩu',
    ])->withInput();
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

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
      'role' => 'required|in:patient,doctor,staff',
    ]);

    $role = $request->input('role');

    $apiUrls = [
      'patient' => 'http://localhost:8081/api/patients/login',
      'doctor'  => 'http://localhost:8082/api/doctors/login',
      'staff'   => 'http://localhost:8082/api/staff/login',
    ];

    $url = $apiUrls[$role];

    try {
      $response = Http::asJson()->post($url, [
        'email' => $request->email,
        'password' => $request->password,
      ]);

      if ($response->successful()) {
        return response()->json([
          'message' => 'Đăng nhập thành công',
          'data' => $response->json(),
        ]);
      }

      return response()->json([
        'error' => 'Sai email hoặc mật khẩu',
        'status' => $response->status(),
        'body' => $response->body(),
      ], 401);
    } catch (\Exception $e) {
      return response()->json([
        'error' => 'Lỗi kết nối tới ' . $role . ' service',
        'message' => $e->getMessage(),
      ], 500);
    }
  }
}

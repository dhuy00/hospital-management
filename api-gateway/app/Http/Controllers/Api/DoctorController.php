<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class DoctorController extends Controller
{

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    try {
      $response = Http::asJson()->post('http://localhost:8082/api/doctors/login', [
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
        'error' => 'Lỗi kết nối tới patient service',
        'message' => $e->getMessage(),
      ], 500);
    }
  }
}

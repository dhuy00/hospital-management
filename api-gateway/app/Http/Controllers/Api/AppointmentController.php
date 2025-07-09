<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
  public function getAllAppointments(): JsonResponse
  {
    try {
      $response = Http::get('http://localhost:8082/api/appointments');

      if ($response->failed()) {
        return response()->json(['error' => 'Không thể lấy dữ liệu cuộc hẹn từ API.'], 500);
      }

      $appointments = $response->json();
      foreach ($appointments as &$appointment) {
        if (!isset($appointment['patientId'])) {
          $appointment['patient'] = null;
          continue;
        }

        $patientResponse = Http::get("http://localhost:8081/api/patients/{$appointment['patientId']}");

        if ($patientResponse->ok()) {
          $appointment['patient'] = $patientResponse->json();
        } else {
          $appointment['patient'] = null;
        }
      }

      return response()->json(['data' => $appointments], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Lỗi khi gọi API: ' . $e->getMessage()], 500);
    }
  }

  public function getAppointmentById($id): JsonResponse
  {
    try {
      $response = Http::get("http://localhost:8082/api/appointments/{$id}");

      if ($response->failed()) {
        return response()->json(['error' => 'Không thể lấy dữ liệu cuộc hẹn từ API.'], 500);
      }

      $appointment = $response->json();

      if (isset($appointment['patientId'])) {
        $patientResponse = Http::get("http://localhost:8081/api/patients/{$appointment['patientId']}");
        if ($patientResponse->ok()) {
          $appointment['patient'] = $patientResponse->json();
        } else {
          $appointment['patient'] = null;
        }
      } else {
        $appointment['patient'] = null;
      }

      return response()->json(['data' => $appointment], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Lỗi khi gọi API: ' . $e->getMessage()], 500);
    }
  }
}

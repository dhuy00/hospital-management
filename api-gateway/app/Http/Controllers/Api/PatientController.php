<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class PatientController extends Controller
{
  public function index()
  {
    try {
      $response = Http::get('http://localhost:8081/api/patients/');

      if ($response->successful()) {
        $patients = $response->json();
        return response()->json($patients);
      } else {
        return response()->json(['error' => 'Failed to fetch patients', 'status' => $response->status()], 500);
      }
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error connecting to patient service', 'message' => $e->getMessage()], 500);
    }
  }

  public function show($id)
  {
    try {
      $patientResponse = Http::get("http://localhost:8081/api/patients/{$id}");

      if (!$patientResponse->successful()) {
        return response()->json(['error' => 'Patient not found'], 404);
      }

      $patient = $patientResponse->json();

      $appointmentResponse = Http::get("http://localhost:8082/api/appointments/patient/{$id}");

      if (!$appointmentResponse->successful()) {
        return response()->json(['error' => 'Appointments not found'], 404);
      }

      $medicalRecords = $appointmentResponse->json();

      return response()->json([
        'patient' => $patient,
        'medicalRecords' => $medicalRecords,
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'error' => 'Error connecting to services',
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function store(Request $request)
  {
    Log::info('Create patient called with data:', $request->all());

    $request->validate([
      'email' => 'required|email',
      'password' => 'required|string|min:6',
      'fullName' => 'required|string|max:255',
      'phone' => 'required|string|max:20',
      'dateOfBirth' => 'required|date',
      'gender' => 'required|string',
      'address' => 'required|string',
    ]);

    try {
      $response = Http::asJson()->post('http://localhost:8081/api/patients/register', [
        'email' => $request->email,
        'password' => $request->password,
        'fullName' => $request->fullName,
        'phone' => $request->phone,
        'dateOfBirth' => $request->dateOfBirth,
        'gender' => $request->gender,
        'address' => $request->address,
      ]);

      Log::info('API Create Patient Response', [
        'status' => $response->status(),
        'body' => $response->body(),
      ]);

      if ($response->successful()) {
        return response()->json(['message' => 'Patient created successfully', 'data' => $response->json()], 201);
      }

      return response()->json(['error' => 'Failed to create patient', 'status' => $response->status(), 'body' => $response->body()], 500);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error connecting to patient service', 'message' => $e->getMessage()], 500);
    }
  }

  public function update(Request $request, $id)
  {
    Log::info('Update called with data:', $request->all());

    $request->validate([
      'fullName' => 'required|string|max:255',
      'email' => 'required|email',
      'dateOfBirth' => 'required|date',
      'phone' => 'required|string|max:20',
      'gender' => 'required|string',
      'address' => 'required|string',
    ]);

    try {
      $response = Http::asJson()->put("http://localhost:8081/api/patients/{$id}", [
        'fullName' => $request->fullName,
        'email' => $request->email,
        'dateOfBirth' => $request->dateOfBirth,
        'phone' => $request->phone,
        'gender' => $request->gender,
        'address' => $request->address,
      ]);

      Log::info('API Response', [
        'status' => $response->status(),
        'body' => $response->body(),
      ]);

      if ($response->successful()) {
        return redirect()->route('patients.show', $id)->with('success', 'Cập nhật thành công');
      }

      return back()->with('error', 'Cập nhật thất bại. API trả về: ' . $response->body());
    } catch (\Exception $e) {
      return back()->with('error', 'Lỗi khi gọi API: ' . $e->getMessage());
    }
  }
}

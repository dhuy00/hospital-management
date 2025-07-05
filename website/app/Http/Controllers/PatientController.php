<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Http::get('http://localhost:8001/api/patients')->json();

        return view('patients.index', compact('patients'));
    }


    public function show($id)
    {
        try {
            $response = Http::get("http://localhost:8001/api/patients/{$id}");

            if ($response->successful()) {
                $data = $response->json();

                $patient = $data['patient'] ?? [];
                $medicalRecords = $data['medicalRecords'] ?? [];

                return view('patients.show', compact('patient', 'medicalRecords'));
            } else {
                return abort(404, 'Patient not found');
            }
        } catch (\Exception $e) {
            return abort(500, 'Error connecting to patient service: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $patient = Http::get("http://localhost:8081/api/patients/{$id}")->json();
        return view('patients.edit', compact('patient'));
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

        $response = Http::asJson()->put("http://localhost:8001/api/patients/{$id}", [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'dateOfBirth' => $request->dateOfBirth,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);

        Log::info('API Response', [
            'status' => $response->status(),
        ]);


        return redirect()->route('patients.show', $id)->with('success', 'Cập nhật thành công');
    }

    public function prescriptionDetail($patientId, $recordId)
    {
        try {
            $response = Http::get("http://localhost:8001/api/prescriptions/patient/{$patientId}");

            if ($response->failed()) {
                return back()->withErrors('Không thể lấy dữ liệu đơn thuốc từ API.');
            }

            $allPrescriptions = $response->json();

            $prescriptionData = collect($allPrescriptions)->firstWhere('prescription_id', (int)$recordId);

            if (!$prescriptionData) {
                return back()->withErrors('Không tìm thấy đơn thuốc.');
            }

            return view('patients.prescription', [
                'patientId' => $patientId,
                'recordId' => $recordId,
                'prescription' => $prescriptionData['medicines'],
            ]);
        } catch (\Exception $e) {
            return back()->withErrors('Lỗi: ' . $e->getMessage());
        }
    }
}

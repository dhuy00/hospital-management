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

        // Validate đầy đủ tất cả các trường
        $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|email',
            'dateOfBirth' => 'required|date',
            'phone' => 'required|string|max:20',
            'gender' => 'required|string',
            'address' => 'required|string',
            'bloodType' => 'nullable|string|max:10',
            'chronicDiseases' => 'nullable|string',
            'allergies' => 'nullable|string',
            'medications' => 'nullable|string',
            'emergencyContactName' => 'nullable|string|max:255',
            'emergencyContactPhone' => 'nullable|string|max:20',
            'insuranceNumber' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:100',
        ]);

        // Gọi API update
        $response = Http::asJson()->put("http://localhost:8001/api/patients/{$id}", [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'dateOfBirth' => $request->dateOfBirth,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'bloodType' => $request->bloodType,
            'chronicDiseases' => $request->chronicDiseases,
            'allergies' => $request->allergies,
            'medications' => $request->medications,
            'emergencyContactName' => $request->emergencyContactName,
            'emergencyContactPhone' => $request->emergencyContactPhone,
            'insuranceNumber' => $request->insuranceNumber,
            'occupation' => $request->occupation,
        ]);

        Log::info('API Response', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        if (!$response->successful()) {
            return back()->withErrors(['error' => 'Lỗi khi cập nhật bệnh nhân.'])->withInput();
        }

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

    public function store(Request $request)
    {
        Log::info('Create patient called with data:', $request->all());

        try {
            $response = Http::asJson()->post('http://localhost:8001/api/patients', $request->all());

            Log::info('API Gateway Create Patient Response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->successful()) {
                return redirect()->route('patients.index')->with('success', 'Tạo bệnh nhân thành công');
            }

            return back()->withErrors('Tạo bệnh nhân thất bại. API Gateway trả về: ' . $response->body());
        } catch (\Exception $e) {
            return back()->withErrors('Lỗi khi kết nối API Gateway: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('patients.create');
    }
}

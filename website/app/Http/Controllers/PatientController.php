<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = [
            ['id' => 1, 'name' => 'Nguyễn Văn A', 'age' => 30, 'gender' => 'Nam'],
            ['id' => 2, 'name' => 'Trần Thị B', 'age' => 25, 'gender' => 'Nữ'],
            ['id' => 3, 'name' => 'Lê Văn C', 'age' => 40, 'gender' => 'Nam'],
        ];

        return view('patients.index', compact('patients'));
    }

    public function show($id)
    {
        $patient = [
            'id' => $id,
            'name' => 'Nguyễn Văn A',
            'age' => 30,
            'gender' => 'Nam',
        ];

        $medicalRecords = [
            [
                'date' => '2025-06-01',
                'doctor' => 'BS. Trần Văn B',
                'diagnosis' => 'Viêm họng cấp',
                'services' => ['Khám nội tổng quát', 'Xét nghiệm máu']
            ],
            [
                'date' => '2025-05-15',
                'doctor' => 'BS. Nguyễn Thị C',
                'diagnosis' => 'Đau dạ dày',
                'services' => ['Khám tiêu hóa', 'Nội soi dạ dày']
            ],
            [
                'date' => '2025-04-02',
                'doctor' => 'BS. Lê Văn D',
                'diagnosis' => 'Kiểm tra định kỳ',
                'services' => ['Khám tổng quát']
            ],
        ];

        return view('patients.show', compact('patient', 'medicalRecords'));
    }

    public function prescriptionDetail($patientId, $recordId)
    {
        // Mock chi tiết đơn thuốc theo recordId
        $prescriptions = [
            1 => [
                ['medicine' => 'Paracetamol', 'dosage' => '500mg', 'quantity' => 10],
                ['medicine' => 'Amoxicillin', 'dosage' => '250mg', 'quantity' => 15],
            ],
            2 => [
                ['medicine' => 'Omeprazole', 'dosage' => '20mg', 'quantity' => 7],
            ],
            3 => [
                ['medicine' => 'Vitamin C', 'dosage' => '500mg', 'quantity' => 30],
            ],
        ];

        $prescription = $prescriptions[$recordId] ?? [];

        return view('patients.prescription', compact('patientId', 'recordId', 'prescription'));
    }
}

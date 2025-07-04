<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function create($appointmentId)
    {
        return view('prescriptions.create', compact('appointmentId'));
    }

    public function store(Request $request, $appointmentId)
    {
        // Lưu dữ liệu (mock)
        return redirect()->route('appointments.show', $appointmentId)->with('success', 'Thêm đơn thuốc thành công!');
    }

    public function edit($id)
    {
        // Mock prescription
        $prescription = [
            'id' => $id,
            'medicines' => 'Paracetamol, Vitamin C',
            'status' => 'Chưa lấy',
        ];

        return view('prescriptions.edit', compact('prescription'));
    }

    public function update(Request $request, $id)
    {
        // Cập nhật dữ liệu (mock)
        return redirect()->route('appointments.index')->with('success', 'Cập nhật đơn thuốc thành công!');
    }
}

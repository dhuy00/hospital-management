<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{

  // Mock data chung
  private function getMockAppointments()
  {
    return [
      ['id' => 1, 'patient_name' => 'Nguyễn Văn A', 'doctor_name' => 'BS. Trần Văn A', 'time' => '2025-07-05 09:00', 'department' => 'Nội tổng quát'],
      ['id' => 2, 'patient_name' => 'Trần Thị B', 'doctor_name' => 'BS. Lê Thị B', 'time' => '2025-07-05 10:00', 'department' => 'Tiêu hóa'],
    ];
  }

public function show($id)
{
    try {
        $response = Http::get("http://localhost:8001/api/appointments/{$id}");

        if ($response->failed()) {
            abort(404, 'Không tìm thấy lịch hẹn.');
        }

        $appointment = $response->json()['data'] ?? null;

        if (!$appointment) {
            abort(404, 'Không tìm thấy dữ liệu lịch hẹn.');
        }

        return view('appointments.show', compact('appointment'));

    } catch (\Exception $e) {
        abort(500, 'Lỗi khi gọi API: ' . $e->getMessage());
    }
}

  public function edit($id)
  {
    $appointment = collect($this->getMockAppointments())->firstWhere('id', $id);
    if (!$appointment) abort(404);

    $departments = ['Nội tổng quát', 'Tai - Mũi - Họng', 'Tiêu hóa', 'Tim mạch'];

    return view('appointments.edit', compact('appointment', 'departments'));
  }

  public function update(Request $request, $id)
  {
    // Validate dữ liệu nếu cần
    // Xử lý update (mock)

    return redirect()->route('appointments.index')->with('success', "Cập nhật lịch hẹn #$id thành công!");
  }


  public function index(Request $request)
  {
    try {
      $response = Http::get('http://localhost:8001/api/appointments');

      if ($response->failed()) {
        return back()->withErrors('Không thể lấy dữ liệu cuộc hẹn từ API.');
      }

      $appointments = $response->json()['data'] ?? [];

      if ($request->filled('patient')) {
        $appointments = array_filter($appointments, function ($a) use ($request) {
          return isset($a['patient']['fullName']) &&
            str_contains(strtolower($a['patient']['fullName']), strtolower($request->patient));
        });
      }

      if ($request->filled('doctor')) {
        $appointments = array_filter($appointments, function ($a) use ($request) {
          return isset($a['doctorName']) &&
            str_contains(strtolower($a['doctorName']), strtolower($request->doctor));
        });
      }

      if ($request->filled('date')) {
        $appointments = array_filter($appointments, function ($a) use ($request) {
          return isset($a['appointmentTime']) &&
            str_starts_with($a['appointmentTime'], $request->date);
        });
      }

      return view('appointments.index', ['appointments' => $appointments]);
    } catch (\Exception $e) {
      return back()->withErrors('Lỗi khi gọi API: ' . $e->getMessage());
    }
  }



  public function destroy($id)
  {
    // Xử lý hủy lịch (mock)
    return redirect()->route('appointments.index')->with('success', "Đã hủy lịch hẹn #$id");
  }

  public function create()
  {
    $patients = [
      ['id' => 1, 'name' => 'Nguyễn Văn A'],
      ['id' => 2, 'name' => 'Trần Thị B'],
    ];

    $departments = ['Nội tổng quát', 'Tai - Mũi - Họng', 'Tiêu hóa', 'Tim mạch'];

    return view('appointments.create', compact('patients', 'departments'));
  }

  public function searchDoctors(Request $request)
  {
    // Lấy dữ liệu từ form
    $department = $request->department;
    $appointmentTime = $request->appointment_time;

    // Mock danh sách bác sĩ rảnh
    $doctors = [
      ['id' => 1, 'name' => 'BS. Trần Văn A', 'department' => 'Nội tổng quát'],
      ['id' => 2, 'name' => 'BS. Lê Thị B', 'department' => 'Tiêu hóa'],
    ];

    $availableDoctors = array_filter($doctors, function ($doc) use ($department) {
      return $doc['department'] === $department;
    });

    return response()->json(array_values($availableDoctors));
  }

  public function showReminders()
  {
    $appointments = [
      [
        'id' => 1,
        'appointment_time' => '2025-07-05 09:30:00',
        'patient' => ['name' => 'Nguyễn Văn A', 'email' => 'a@example.com'],
        'doctor' => ['name' => 'BS. Trần Văn A'],
        'department' => 'Nội tổng quát',
        'services' => ['Khám nội tổng quát', 'Siêu âm tim'],
        'note' => 'Nhớ mang BHYT',
      ],
      [
        'id' => 2,
        'appointment_time' => '2025-07-06 15:00:00',
        'patient' => ['name' => 'Trần Thị B', 'email' => 'b@example.com'],
        'doctor' => ['name' => 'BS. Lê Thị B'],
        'department' => 'Tiêu hóa',
        'services' => ['Khám tiêu hóa'],
        'note' => null,
      ],
    ];

    return view('notifications.appointments', compact('appointments'));
  }

  public function store(Request $request)
  {
    // Xử lý lưu vào database, tạm thời mock
    return redirect()->route('appointments.create')->with('success', 'Đặt lịch thành công!');
  }
}

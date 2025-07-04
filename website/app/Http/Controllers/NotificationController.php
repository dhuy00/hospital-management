<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
  private $mockPatients = [
    ['id' => 1, 'name' => 'Nguyễn Văn A', 'email' => 'a@gmail.com', 'phone' => '0912345678'],
    ['id' => 2, 'name' => 'Trần Thị B', 'email' => 'b@gmail.com', 'phone' => '0987654321'],
  ];


  public function index(Request $request)
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

    // Lọc theo query string
    $filtered = array_filter($appointments, function ($appointment) use ($request) {
      return (!$request->patient || str_contains(strtolower($appointment['patient']['name']), strtolower($request->patient)))
        && (!$request->doctor || str_contains(strtolower($appointment['doctor']['name']), strtolower($request->doctor)))
        && (!$request->department || $appointment['department'] === $request->department);
    });

    $departments = ['Nội tổng quát', 'Tai - Mũi - Họng', 'Tiêu hóa', 'Tim mạch'];

    return view('notifications.index', [
      'appointments' => $filtered,
      'departments' => $departments,
      'search' => $request->all(),
    ]);
  }


  public function sendAppointmentReminder(Request $request)
  {
    $patient = $this->findPatient($request->patient_id);
    $time = $request->appointment_time;

    // Mock gửi Email
    logger("Send Email: Nhắc nhở lịch khám cho {$patient['name']} lúc {$time}");

    return redirect()->back()->with('success', 'Đã gửi nhắc nhở lịch khám qua email.');
  }

  public function sendAppointmentReminderSms(Request $request)
  {
    $patient = $this->findPatient($request->patient_id);
    $time = $request->appointment_time;

    // Mock gửi SMS
    logger("Send SMS: Nhắc nhở lịch khám cho {$patient['name']} lúc {$time}");

    return redirect()->back()->with('success', 'Đã gửi nhắc nhở lịch khám qua SMS.');
  }

  public function sendPrescriptionReady(Request $request)
  {
    $patient = $this->findPatient($request->patient_id);

    // Mock gửi Email
    logger("Send Email: Đơn thuốc của {$patient['name']} đã sẵn sàng.");

    return redirect()->back()->with('success', 'Đã gửi thông báo đơn thuốc qua email.');
  }

  public function sendPrescriptionReadySms(Request $request)
  {
    $patient = $this->findPatient($request->patient_id);

    // Mock gửi SMS
    logger("Send SMS: Đơn thuốc của {$patient['name']} đã sẵn sàng.");

    return redirect()->back()->with('success', 'Đã gửi thông báo đơn thuốc qua SMS.');
  }

  private function findPatient($id)
  {
    return collect($this->mockPatients)->firstWhere('id', $id);
  }
}

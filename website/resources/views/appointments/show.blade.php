@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
  <h1 class="text-2xl font-bold">Chi tiết lịch hẹn #{{ $appointment['id'] }}</h1>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-lg shadow">
    <div class="space-y-2">
      <h2 class="text-lg font-semibold">Thông tin bệnh nhân</h2>
      <p><strong>Họ tên:</strong> {{ $appointment['patient']['fullName'] ?? 'Chưa có' }}</p>
      <p><strong>Điện thoại:</strong> {{ $appointment['patient']['phone'] ?? '---' }}</p>
      <p><strong>Ngày sinh:</strong> {{ \Carbon\Carbon::parse($appointment['patient']['dateOfBirth'])->format('d/m/Y') ?? '---' }}</p>
      <p><strong>Giới tính:</strong> {{ $appointment['patient']['gender'] ?? '---' }}</p>
      <p><strong>Địa chỉ:</strong> {{ $appointment['patient']['address'] ?? '---' }}</p>
    </div>

    <div class="space-y-2">
      <h2 class="text-lg font-semibold">Thông tin cuộc hẹn</h2>
      <p><strong>Bác sĩ:</strong> {{ $appointment['doctorName'] ?? '---' }}</p>
      <p><strong>Khoa:</strong> {{ $appointment['doctorDepartment'] ?? '---' }}</p>
      <p><strong>Dịch vụ:</strong> {{ $appointment['serviceName'] ?? '---' }}</p>
      <p><strong>Thời gian:</strong> {{ \Carbon\Carbon::parse($appointment['appointmentTime'])->format('d/m/Y H:i') }}</p>
      <p><strong>Lý do khám:</strong> {{ $appointment['reason'] ?? '---' }}</p>
      <p><strong>Trạng thái:</strong>
        <span class="inline-block px-2 py-1 rounded-full text-xs
                    {{ $appointment['status'] === 'SCHEDULED' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">
          {{ $appointment['status'] }}
        </span>
      </p>
    </div>
  </div>

  <div class="flex gap-4">
    <a href="{{ route('appointments.index') }}"
      class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded shadow">
      Quay lại
    </a>

    <a href="{{ route('prescriptions.create', $appointment['id']) }}"
      class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow">
      Thêm đơn thuốc
    </a>
  </div>
</div>
@endsection
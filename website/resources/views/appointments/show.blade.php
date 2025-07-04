@extends('layouts.app')

@section('content')
<div class="p-6">
  <h1 class="text-xl font-bold mb-4">Chi tiết lịch hẹn #{{ $appointment['id'] }}</h1>

  <div class="space-y-2">
    <p><strong>Bệnh nhân:</strong> {{ $appointment['patient_name'] }}</p>
    <p><strong>Bác sĩ:</strong> {{ $appointment['doctor_name'] }}</p>
    <p><strong>Thời gian:</strong> {{ $appointment['time'] }}</p>
    <p><strong>Khoa:</strong> {{ $appointment['department'] }}</p>
  </div>

  <a href="{{ route('prescriptions.create', $appointment['id']) }}"
    class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
    Thêm đơn thuốc
  </a>

  <a href="{{ route('appointments.index') }}" class="mt-4 inline-block bg-gray-400 text-white px-4 py-2 rounded">Quay lại</a>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Chi tiết bệnh nhân')

@section('content')
<h1 class="text-2xl font-bold mb-4">Chi tiết bệnh nhân</h1>

<div class="bg-white p-6 rounded shadow-md space-y-3">
  <p><strong>ID:</strong> {{ $patient['id'] }}</p>
  <p><strong>Tên:</strong> {{ $patient['name'] }}</p>
  <p><strong>Tuổi:</strong> {{ $patient['age'] }}</p>
  <p><strong>Giới tính:</strong> {{ $patient['gender'] }}</p>
</div>

<h2 class="text-xl font-semibold mt-6 mb-3">Lịch sử khám bệnh</h2>

<div class="space-y-4">
  @foreach($medicalRecords as $record)
  <div class="bg-gray-50 p-4 rounded shadow-sm flex justify-between items-center">
    <div class="">
    <p><strong>Ngày khám:</strong> {{ $record['date'] }}</p>
    <p><strong>Bác sĩ:</strong> {{ $record['doctor'] }}</p>
    <p><strong>Chẩn đoán:</strong> {{ $record['diagnosis'] }}</p>
    <p><strong>Dịch vụ sử dụng:</strong></p>
    <ul class="list-disc list-inside">
      @foreach($record['services'] as $service)
      <li>{{ $service }}</li>
      @endforeach
    </ul>
    </div>
    <a href="{{ route('patients.prescription', ['patientId' => $patient['id'], 'recordId' => $loop->iteration]) }}"
      class="inline-block bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
      Xem đơn thuốc
    </a>
  </div>
  @endforeach
</div>

<a href="{{ route('patients.index') }}" class="inline-block mt-4 text-blue-500 hover:underline">← Quay lại danh sách</a>
@endsection
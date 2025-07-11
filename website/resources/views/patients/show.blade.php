@extends('layouts.app')

@section('title', 'Chi tiết bệnh nhân')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Chi tiết bệnh nhân</h1>
    <a href="{{ route('patients.edit', $patient['id']) }}"
        class="flex items-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
        <i data-lucide="edit" class="mr-2 w-4 h-4"></i> Chỉnh sửa
    </a>
</div>

<div class="bg-white p-6 rounded-lg shadow space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <p><strong>ID:</strong> {{ $patient['id'] }}</p>
        <p><strong>Email:</strong> {{ $patient['email'] }}</p>
        <p><strong>Tên:</strong> {{ $patient['fullName'] }}</p>
        <p><strong>Ngày sinh:</strong> {{ $patient['dateOfBirth'] }}</p>
        <p><strong>Số điện thoại:</strong> {{ $patient['phone'] }}</p>
        <p><strong>Giới tính:</strong> {{ $patient['gender'] }}</p>
        <p><strong>Nhóm máu:</strong> {{ $patient['blood_type'] ?? 'Chưa cập nhật' }}</p>
        <p><strong>Bệnh mãn tính:</strong> {{ $patient['chronic_diseases'] ?? 'Không có' }}</p>
        <p><strong>Dị ứng:</strong> {{ $patient['allergies'] ?? 'Không có' }}</p>
        <p><strong>Thuốc đang dùng:</strong> {{ $patient['medications'] ?? 'Không có' }}</p>
        <p><strong>Người liên hệ khẩn cấp:</strong> {{ $patient['emergency_contact_name'] ?? 'Chưa cập nhật' }}</p>
        <p><strong>Điện thoại khẩn cấp:</strong> {{ $patient['emergency_contact_phone'] ?? 'Chưa cập nhật' }}</p>
        <p><strong>Số bảo hiểm:</strong> {{ $patient['insurance_number'] ?? 'Chưa cập nhật' }}</p>
        <p><strong>Nghề nghiệp:</strong> {{ $patient['occupation'] ?? 'Chưa cập nhật' }}</p>
        <p class="md:col-span-2"><strong>Địa chỉ:</strong> {{ $patient['address'] }}</p>
    </div>
</div>

<h2 class="text-xl font-semibold mt-8 mb-4">Lịch sử khám bệnh</h2>

<div class="space-y-4">
    @forelse($medicalRecords as $record)
    <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transition">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-3">
            <p><strong>Ngày khám:</strong> {{ $record['appointmentTime'] }}</p>
            <p><strong>Bác sĩ:</strong> {{ $record['doctorName'] }}</p>
            <p><strong>Lý do:</strong> {{ $record['reason'] }}</p>
            <p><strong>Khoa:</strong> {{ $record['doctorDepartment'] }}</p>
            <p class="md:col-span-2"><strong>Dịch vụ sử dụng:</strong> {{ $record['serviceName'] }}</p>
        </div>
        <a href="{{ route('patients.prescription', ['patientId' => $patient['id'], 'recordId' => $loop->iteration]) }}"
            class="inline-flex items-center bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
            <i data-lucide="file-text" class="mr-2 w-4 h-4"></i> Xem đơn thuốc
        </a>
    </div>
    @empty
    <p class="text-gray-500 italic">Chưa có lịch sử khám bệnh</p>
    @endforelse
</div>

<a href="{{ route('patients.index') }}"
    class="inline-block mt-6 text-blue-500 hover:underline transition">← Quay lại danh sách</a>
@endsection

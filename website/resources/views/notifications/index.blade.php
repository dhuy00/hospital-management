@extends('layouts.app')

@section('content')
<div class="p-8 space-y-8">
    <h1 class="text-2xl font-bold mb-6">Gửi thông báo nhắc lịch khám</h1>
    
    <div class="mb-6 p-4 bg-gray-50 rounded-xl shadow">
        <form method="GET" action="{{ route('notifications.appointments') }}" class="flex flex-wrap gap-4">
            <input type="text" name="patient" placeholder="Tìm theo tên bệnh nhân"
                value="{{ $search['patient'] ?? '' }}"
                class="border p-2 rounded w-[200px]">

            <input type="text" name="doctor" placeholder="Tìm theo tên bác sĩ"
                value="{{ $search['doctor'] ?? '' }}"
                class="border p-2 rounded w-[200px]">

            <select name="department" class="border p-2 rounded w-[200px]">
                <option value="">Tất cả khoa</option>
                @foreach ($departments as $dept)
                <option value="{{ $dept }}" {{ ($search['department'] ?? '') === $dept ? 'selected' : '' }}>
                    {{ $dept }}
                </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Tìm kiếm
            </button>
        </form>
    </div>

    @foreach ($appointments as $appointment)
    <div class="bg-white rounded-xl shadow p-6 space-y-3">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-lg font-semibold">Lịch hẹn ngày {{ date('d/m/Y H:i', strtotime($appointment['appointment_time'])) }}</h2>
                <p class="text-gray-700">Bệnh nhân: <strong>{{ $appointment['patient']['name'] }}</strong> | Email: {{ $appointment['patient']['email'] }}</p>
                <p class="text-gray-700">Bác sĩ: <strong>{{ $appointment['doctor']['name'] }}</strong> | Khoa: {{ $appointment['department'] }}</p>
                <p class="text-gray-700">Dịch vụ: {{ implode(', ', $appointment['services']) }}</p>
                <p class="text-gray-700">Ghi chú: {{ $appointment['note'] ?? 'Không có' }}</p>
            </div>
            <div class="flex flex-col space-y-2">
                <form method="POST" action="{{ route('notifications.sendAppointmentReminder') }}">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ $appointment['id'] }}">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Gửi Email</button>
                </form>

                <form method="POST" action="{{ route('notifications.sendAppointmentReminderSms') }}">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ $appointment['id'] }}">
                    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Gửi SMS</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Chỉnh sửa lịch hẹn #{{ $appointment['id'] }}</h1>

    <form method="POST" action="{{ route('appointments.update', $appointment['id']) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label>Bệnh nhân:</label>
            <input type="text" name="patient_name" class="w-full border p-2 rounded" value="{{ $appointment['patient_name'] }}">
        </div>

        <div>
            <label>Bác sĩ:</label>
            <input type="text" name="doctor_name" class="w-full border p-2 rounded" value="{{ $appointment['doctor_name'] }}">
        </div>

        <div>
            <label>Thời gian:</label>
            <input type="datetime-local" name="time" class="w-full border p-2 rounded" value="{{ \Carbon\Carbon::parse($appointment['time'])->format('Y-m-d\TH:i') }}">
        </div>

        <div>
            <label>Khoa:</label>
            <select name="department" class="w-full border p-2 rounded">
                @foreach($departments as $dept)
                    <option value="{{ $dept }}" @if($dept == $appointment['department']) selected @endif>{{ $dept }}</option>
                @endforeach
            </select>
        </div>

        <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Lưu</button>
        <a href="{{ route('appointments.index') }}" class="inline-block bg-gray-400 text-white px-4 py-2 rounded">Hủy</a>
    </form>
</div>
@endsection

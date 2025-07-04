@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Danh sách lịch hẹn</h1>

    <form method="GET" class="mb-4 flex gap-4">
        <input type="text" name="patient" placeholder="Tên bệnh nhân" class="border p-2 rounded" value="{{ request('patient') }}">
        <input type="text" name="doctor" placeholder="Tên bác sĩ" class="border p-2 rounded" value="{{ request('doctor') }}">
        <input type="date" name="date" class="border p-2 rounded" value="{{ request('date') }}">
        <button class="bg-blue-500 text-white px-4 py-2 rounded">Tìm kiếm</button>
    </form>

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Bệnh nhân</th>
                <th class="p-2">Bác sĩ</th>
                <th class="p-2">Thời gian</th>
                <th class="p-2">Khoa</th>
                <th class="p-2">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
            <tr class="border-t">
                <td class="p-2">{{ $appointment['patient_name'] }}</td>
                <td class="p-2">{{ $appointment['doctor_name'] }}</td>
                <td class="p-2">{{ $appointment['time'] }}</td>
                <td class="p-2">{{ $appointment['department'] }}</td>
                <td class="p-2 flex gap-2">
                    <a href="{{ route('appointments.show', ['id' => $appointment['id']]) }}" class="text-blue-500">Chi tiết</a>
                    <a href="{{ route('appointments.edit', ['id' => $appointment['id']]) }}" class="text-green-500">Sửa</a>
                    <form method="POST" action="{{ route('appointments.destroy', ['id' => $appointment['id']]) }}" onsubmit="return confirm('Bạn có chắc muốn hủy?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Hủy</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="p-2 text-center text-gray-500">Không có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

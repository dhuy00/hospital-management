@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Danh sách lịch hẹn</h1>
        <a href="{{ route('appointments.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            + Thêm lịch hẹn
        </a>
    </div>

    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="patient" placeholder="Tên bệnh nhân" class="border p-2 rounded w-full" value="{{ request('patient') }}">
        <input type="text" name="doctor" placeholder="Tên bác sĩ" class="border p-2 rounded w-full" value="{{ request('doctor') }}">
        <input type="date" name="date" class="border p-2 rounded w-full" value="{{ request('date') }}">
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full md:w-auto">Tìm kiếm</button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-left">
                    <th class="p-3">Bệnh nhân</th>
                    <th class="p-3">Bác sĩ</th>
                    <th class="p-3">Thời gian</th>
                    <th class="p-3">Khoa</th>
                    <th class="p-3 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $appointment['patient']['fullName'] ?? 'Chưa có' }}</td>
                    <td class="p-3">{{ $appointment['doctorName'] ?? 'Chưa rõ' }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($appointment['appointmentTime'])->format('d/m/Y H:i') }}</td>
                    <td class="p-3">{{ $appointment['doctorDepartment'] ?? '-' }}</td>
                    <td class="p-3 flex justify-center gap-3">
                        <a href="{{ route('appointments.show', ['id' => $appointment['id']]) }}" class="text-blue-500 hover:underline">Chi tiết</a>
                        <a href="{{ route('appointments.edit', ['id' => $appointment['id']]) }}" class="text-green-500 hover:underline">Sửa</a>
                        <form method="POST" action="{{ route('appointments.destroy', ['id' => $appointment['id']]) }}" onsubmit="return confirm('Bạn có chắc muốn hủy?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Hủy</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Không có dữ liệu</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

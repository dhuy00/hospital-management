@extends('layouts.app')

@section('title', 'Danh sách bệnh nhân')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Danh sách bệnh nhân</h1>
    <a href="{{ route('patients.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
        + Thêm bệnh nhân
    </a>
</div>

<table class="min-w-full bg-white rounded shadow-md">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">ID</th>
            <th class="p-3 text-left">Tên</th>
            <th class="p-3 text-left">Ngày sinh</th>
            <th class="p-3 text-left">Địa chỉ</th>
            <th class="p-3 text-left">Giới tính</th>
            <th class="p-3 text-left">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($patients as $patient)
        <tr class="border-t">
            <td class="p-3">{{ $patient['id'] }}</td>
            <td class="p-3">{{ $patient['fullName'] }}</td>
            <td class="p-3">{{ $patient['dateOfBirth'] }}</td>
            <td class="p-3">{{ $patient['address'] }}</td>
            <td class="p-3">{{ $patient['gender'] }}</td>
            <td class="p-3">
                <a href="{{ route('patients.show', $patient['id']) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                    Chi tiết
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
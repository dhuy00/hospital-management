@extends('layouts.app')

@section('title', 'Danh sách bệnh nhân')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Danh sách bệnh nhân</h1>

    <table class="min-w-full bg-white rounded shadow-md">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">ID</th>
                <th class="p-3 text-left">Tên</th>
                <th class="p-3 text-left">Tuổi</th>
                <th class="p-3 text-left">Giới tính</th>
                <th class="p-3 text-left">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr class="border-t">
                    <td class="p-3">{{ $patient['id'] }}</td>
                    <td class="p-3">{{ $patient['name'] }}</td>
                    <td class="p-3">{{ $patient['age'] }}</td>
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

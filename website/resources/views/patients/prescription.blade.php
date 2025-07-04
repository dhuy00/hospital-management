@extends('layouts.app')

@section('title', 'Đơn thuốc lần khám ' . $recordId)

@section('content')
    <h1 class="text-2xl font-bold mb-4">Đơn thuốc - Lần khám {{ $recordId }}</h1>

    @if(count($prescription) > 0)
        <table class="min-w-full bg-white rounded shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">Tên thuốc</th>
                    <th class="p-3 text-left">Liều lượng</th>
                    <th class="p-3 text-left">Số lượng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prescription as $item)
                    <tr class="border-t">
                        <td class="p-3">{{ $item['medicine'] }}</td>
                        <td class="p-3">{{ $item['dosage'] }}</td>
                        <td class="p-3">{{ $item['quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-500">Không có đơn thuốc cho lần khám này.</p>
    @endif

    <a href="{{ route('patients.show', $patientId) }}" class="inline-block mt-4 text-blue-500 hover:underline">← Quay lại bệnh nhân</a>
@endsection

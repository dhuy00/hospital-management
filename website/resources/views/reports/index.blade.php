@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Báo cáo & Thống kê</h1>

    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-2">Thống kê số lượng bệnh nhân theo tháng</h2>
        <table class="table-auto w-full border text-center">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Tháng</th>
                    <th class="px-4 py-2">Số bệnh nhân</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patientsPerMonth as $month => $count)
                    <tr>
                        <td class="border px-4 py-2">{{ $month }}</td>
                        <td class="border px-4 py-2">{{ $count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <h2 class="text-lg font-semibold mb-2">Báo cáo số lượng đơn thuốc đã cấp</h2>
        <table class="table-auto w-full border text-center">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Ngày</th>
                    <th class="px-4 py-2">Số đơn thuốc</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prescriptionsPerDay as $day => $count)
                    <tr>
                        <td class="border px-4 py-2">{{ $day }}</td>
                        <td class="border px-4 py-2">{{ $count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

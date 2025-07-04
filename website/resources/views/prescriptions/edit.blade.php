@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Chỉnh sửa đơn thuốc #{{ $prescription['id'] }}</h1>

    <form method="POST" action="{{ route('prescriptions.update', $prescription['id']) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label>Thuốc:</label>
            <input type="text" name="medicines" class="w-full border p-2 rounded" value="{{ $prescription['medicines'] }}">
        </div>

        <div>
            <label>Tình trạng:</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="Chưa lấy" @if($prescription['status'] == 'Chưa lấy') selected @endif>Chưa lấy</option>
                <option value="Đã lấy" @if($prescription['status'] == 'Đã lấy') selected @endif>Đã lấy</option>
            </select>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cập nhật</button>
        <a href="{{ route('appointments.index') }}" class="inline-block bg-gray-400 text-white px-4 py-2 rounded">Hủy</a>
    </form>
</div>
@endsection

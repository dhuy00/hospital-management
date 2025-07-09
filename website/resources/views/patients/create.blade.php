@extends('layouts.app')

@section('content')
<div class="p-8 max-w-4xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-100">
    <h1 class="text-xl font-bold mb-8 text-center text-blue-600">Thêm Bệnh Nhân Mới</h1>

    {{-- Hiển thị lỗi --}}
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
        <ul class="list-disc pl-5 space-y-1 text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Thông báo thành công --}}
    @if (session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('patients.store') }}" class="space-y-6">
        @csrf

        <div>
            <label class="block mb-2 font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
            <input
                type="email"
                name="email"
                class="border-gray-300 border rounded-md w-full p-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Nhập email bệnh nhân"
                value="{{ old('email') }}" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">Mật khẩu <span class="text-red-500">*</span></label>
            <input
                type="password"
                name="password"
                class="border-gray-300 border rounded-md w-full p-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Tối thiểu 6 ký tự"
                required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">Họ và tên <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="fullName"
                class="border-gray-300 border rounded-md w-full p-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Họ và tên đầy đủ"
                value="{{ old('fullName') }}" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">Số điện thoại <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="phone"
                class="border-gray-300 border rounded-md w-full p-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="VD: 0987654321"
                value="{{ old('phone') }}" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">Ngày sinh <span class="text-red-500">*</span></label>
            <input
                type="date"
                name="dateOfBirth"
                class="border-gray-300 border rounded-md w-full p-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('dateOfBirth') }}" required>
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">Giới tính <span class="text-red-500">*</span></label>
            <select
                name="gender"
                class="border-gray-300 border rounded-md w-full p-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                required>
                <option value="">Chọn giới tính</option>
                <option value="MALE" {{ old('gender') == 'MALE' ? 'selected' : '' }}>Nam</option>
                <option value="FEMALE" {{ old('gender') == 'FEMALE' ? 'selected' : '' }}>Nữ</option>
                <option value="OTHER" {{ old('gender') == 'OTHER' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">Địa chỉ <span class="text-red-500">*</span></label>
            <textarea
                name="address"
                class="border-gray-300 border rounded-md w-full p-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                rows="3"
                placeholder="Nhập địa chỉ nơi cư trú"
                required>{{ old('address') }}</textarea>
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('patients.index') }}"
               class="px-5 py-2.5 rounded-md bg-gray-300 text-gray-700 hover:bg-gray-400 transition">
               Hủy
            </a>
            <button
                type="submit"
                class="px-5 py-2.5 rounded-md bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 transition">
                Lưu
            </button>
        </div>
    </form>
</div>
@endsection

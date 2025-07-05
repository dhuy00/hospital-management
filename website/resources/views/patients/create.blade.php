@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Thêm bệnh nhân mới</h1>

    <form method="POST" action="{{ route('patients.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1">Email:</label>
            <input type="email" name="email" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label class="block mb-1">Mật khẩu:</label>
            <input type="password" name="password" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label class="block mb-1">Họ và tên:</label>
            <input type="text" name="fullName" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label class="block mb-1">Số điện thoại:</label>
            <input type="text" name="phone" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label class="block mb-1">Ngày sinh:</label>
            <input type="date" name="dateOfBirth" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label class="block mb-1">Giới tính:</label>
            <select name="gender" class="border p-2 rounded w-full" required>
                <option value="MALE">Nam</option>
                <option value="FEMALE">Nữ</option>
                <option value="OTHER">Khác</option>
            </select>
        </div>

        <div>
            <label class="block mb-1">Địa chỉ:</label>
            <textarea name="address" class="border p-2 rounded w-full" rows="3" required></textarea>
        </div>

        <div class="space-x-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lưu</button>
            <a href="{{ route('appointments.index') }}" class="inline-block bg-gray-400 text-white px-4 py-2 rounded">Hủy</a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.guest')

@section('title', 'Đăng nhập')

@section('content')
<div class="bg-white p-6 rounded-md w-[30%] shadow-md ">
    <h2 class="text-xl font-bold mb-4">Đăng nhập</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4 flex flex-col gap-2">
            <label>Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
        </div>
        <div class="mb-4 flex flex-col gap-2">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
        </div>

        <div class="mb-4 flex flex-col gap-2">
            <label>Đăng nhập với tư cách</label>
            <select name="role" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <option value="patient">Bệnh nhân</option>
                <option value="doctor">Bác sĩ</option>
                <option value="staff">Nhân viên</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded hover:bg-blue-600">
            Đăng nhập
        </button>

        <div class="text-center mt-2">
            Bạn là bệnh nhân chưa có tài khoản? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Đăng ký ngay</a>
        </div>

    </form>
</div>
@endsection
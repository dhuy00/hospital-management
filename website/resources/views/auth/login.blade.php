@extends('layouts.guest')

@section('title', 'Đăng nhập')

@section('content')
<div class="bg-white p-6 rounded-md w-[30%] shadow-md ">
    <h2 class="text-xl font-bold mb-4">Đăng nhập</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded hover:bg-blue-600">
            Đăng nhập
        </button>
    </form>
    <div class="mt-4 text-sm text-center">
        Chưa có tài khoản? <a href="{{ route('register') }}" class="text-blue-500">Đăng ký</a>
    </div>
</div>
@endsection

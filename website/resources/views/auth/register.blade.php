@extends('layouts.guest')

@section('title', 'Đăng ký')

@section('content')
<div class="bg-white p-6 rounded-md shadow-md w-[500px]">
    <h2 class="text-xl font-bold mb-4">Đăng ký</h2>

    @if ($errors->any())
        <div class="text-red-500 mb-4">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-4">
            <label>Tên</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label>Nhập lại mật khẩu</label>
            <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
        </div>
        <button type="submit" class="bg-green-500 text-white w-full py-2 rounded hover:bg-green-600">
            Đăng ký
        </button>
    </form>

    <div class="mt-4 text-sm text-center">
        Đã có tài khoản? <a href="{{ route('login') }}" class="text-blue-500">Đăng nhập</a>
    </div>
</div>
@endsection

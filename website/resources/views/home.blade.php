@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="p-6 bg-green-100 rounded shadow-md">
    @if(session()->has('user'))
        <h2 class="text-xl font-bold mb-4">
            Chào mừng, {{ session('user')['name'] ?? 'Người dùng' }}!
        </h2>
    @else
        <h2 class="text-xl font-bold mb-4">
            Chào mừng!
        </h2>
    @endif

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            Đăng xuất
        </button>
    </form>
</div>
@endsection

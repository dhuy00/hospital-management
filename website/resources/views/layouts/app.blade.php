<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="flex min-h-screen bg-gray-100">

    {{-- Sidebar --}}
    <div class="w-64 bg-white shadow-md p-4 space-y-6">
        <h2 class="text-xl font-bold">Quản lý</h2>

        <ul class="space-y-3 text-gray-700">
            @auth
            @if(auth()->user()->role === 'admin')
            <li><a href="#">Quản lý người dùng</a></li>
            <li><a href="#">Thống kê</a></li>
            <li><a href="#">Cài đặt</a></li>
            @elseif(auth()->user()->role === 'staff')
            <li><a href="/patients">Bệnh nhân</a></li>
            <li><a href="/appointments">Lịch hẹn</a></li>
            <li><a href="/prescriptions">Đơn thuốc</a></li>
            <li><a href="/notifications">Thông báo</a></li>
            <li><a href="/reports">Thống kê</a></li>
            @else
            <li class="text-gray-400">Không có quyền truy cập</li>
            @endif
            @else
            <li class="text-gray-400">Vui lòng đăng nhập</li>
            @endauth
        </ul>
    </div>

    {{-- Nội dung --}}
    <div class="flex-1 p-6">
        @yield('content')
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
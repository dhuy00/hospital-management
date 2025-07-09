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
    <div class="w-64 bg-white shadow-lg p-4 space-y-6">
        <h2 class="text-2xl font-bold text-blue-600">Quản lý</h2>

        <ul class="space-y-6 font-medium text-gray-700">
            @auth
            @if(auth()->user()->role === 'admin')
            <li>
                <a href="#" class="flex items-center space-x-2 hover:text-blue-600">
                    <i data-lucide="users"></i>
                    <span>Quản lý người dùng</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-2 hover:text-blue-600">
                    <i data-lucide="bar-chart-2"></i>
                    <span>Thống kê</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-2 hover:text-blue-600">
                    <i data-lucide="settings"></i>
                    <span>Cài đặt</span>
                </a>
            </li>
            @elseif(auth()->user()->role === 'staff')
            <li>
                <a href="/patients" class="flex items-center space-x-2 hover:text-blue-600">
                    <i data-lucide="user"></i>
                    <span>Bệnh nhân</span>
                </a>
            </li>
            <li>
                <a href="/appointments" class="flex items-center space-x-2 hover:text-blue-600">
                    <i data-lucide="calendar"></i>
                    <span>Lịch hẹn</span>
                </a>
            </li>
            <li>
                <a href="/prescriptions" class="flex items-center space-x-2 hover:text-blue-600">
                    <i data-lucide="file-text"></i>
                    <span>Đơn thuốc</span>
                </a>
            </li>
            <li>
                <a href="/notifications" class="flex items-center space-x-2 hover:text-blue-600">
                    <i data-lucide="bell"></i>
                    <span>Thông báo</span>
                </a>
            </li>
            <li>
                <a href="/reports" class="flex items-center space-x-2 hover:text-blue-600">
                    <i data-lucide="bar-chart"></i>
                    <span>Thống kê</span>
                </a>
            </li>
            @else
            <li class="text-gray-400">Không có quyền truy cập</li>
            @endif
            @else
            <li class="text-gray-400">Vui lòng đăng nhập</li>
            @endauth
        </ul>
    </div>

    {{-- Nội dung và Header --}}
    <div class="flex-1 flex flex-col">
        {{-- Header --}}
        <div class="flex items-center justify-between bg-white shadow px-6 py-4">
            <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
            @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                    <i data-lucide="log-out" class="mr-2"></i> Logout
                </button>
            </form>
            @endauth
        </div>

        {{-- Nội dung --}}
        <div class="flex-1 p-6">
            @yield('content')
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>

@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Thêm đơn thuốc cho lịch hẹn #{{ $appointmentId }}</h1>

    <form method="POST" action="{{ route('prescriptions.store', $appointmentId) }}" class="space-y-4">
        @csrf

        <div id="medicines-list" class="space-y-4">
            <div class="medicine-item flex gap-4">
                <input type="text" name="medicines[0][name]" class="border p-2 rounded w-1/3" placeholder="Tên thuốc" required>
                <input type="text" name="medicines[0][dosage]" class="border p-2 rounded w-1/4" placeholder="Liều lượng" required>
                <input type="text" name="medicines[0][usage]" class="border p-2 rounded w-1/3" placeholder="Cách dùng" required>
                <button type="button" onclick="removeMedicine(this)" class="bg-red-500 text-white px-2 rounded">Xóa</button>
            </div>
        </div>

        <button type="button" onclick="addMedicine()" class="bg-green-500 text-white px-3 py-1 rounded">+ Thêm thuốc</button>

        <div>
            <label>Tình trạng:</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="Chưa lấy">Chưa lấy</option>
                <option value="Đã lấy">Đã lấy</option>
            </select>
        </div>

        <div class="space-x-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lưu</button>
            <a href="{{ route('appointments.show', $appointmentId) }}" class="inline-block bg-gray-400 text-white px-4 py-2 rounded">Hủy</a>
        </div>
    </form>
</div>

<script>
let index = 1;

function addMedicine() {
    const container = document.getElementById('medicines-list');
    const div = document.createElement('div');
    div.className = 'medicine-item flex gap-4';
    div.innerHTML = `
        <input type="text" name="medicines[${index}][name]" class="border p-2 rounded w-1/3" placeholder="Tên thuốc" required>
        <input type="text" name="medicines[${index}][dosage]" class="border p-2 rounded w-1/4" placeholder="Liều lượng" required>
        <input type="text" name="medicines[${index}][usage]" class="border p-2 rounded w-1/3" placeholder="Cách dùng" required>
        <button type="button" onclick="removeMedicine(this)" class="bg-red-500 text-white px-2 rounded">Xóa</button>
    `;
    container.appendChild(div);
    index++;
}

function removeMedicine(button) {
    button.parentElement.remove();
}
</script>
@endsection

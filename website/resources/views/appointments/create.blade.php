@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Tạo lịch hẹn</h1>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 mb-4">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('appointments.store') }}">
  @csrf
  <div class="mb-4">
    <label>Bệnh nhân</label>
    <select name="patient_id" class="w-full border p-2 rounded">
      @foreach ($patients as $patient)
      <option value="{{ $patient['id'] }}">{{ $patient['name'] }}</option>
      @endforeach
    </select>
  </div>

  <div class="mb-4">
    <label>Khoa khám</label>
    <select id="department" name="department" class="w-full border p-2 rounded">
      @foreach ($departments as $dept)
      <option value="{{ $dept }}">{{ $dept }}</option>
      @endforeach
    </select>
  </div>

  <div class="mb-4">
    <label>Thời gian khám</label>
    <input type="datetime-local" name="appointment_time" id="appointment_time" class="w-full border p-2 rounded">
  </div>

  <div class="mb-4">
    <button type="button" onclick="loadDoctors()" class="bg-blue-500 text-white px-3 py-1 rounded">
      Tìm bác sĩ
    </button>
  </div>

  <div class="mb-4">
    <label>Bác sĩ</label>
    <select name="doctor_id" id="doctor_id" class="w-full border p-2 rounded">
      <option value="">-- Chọn bác sĩ --</option>
    </select>
  </div>

  <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Đặt lịch</button>
</form>

<script>
  function loadDoctors() {
    const department = document.getElementById('department').value;
    const appointmentTime = document.getElementById('appointment_time').value;

    fetch("{{ route('appointments.searchDoctors') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          department,
          appointment_time: appointmentTime
        })
      })

      .then(response => response.json())
      .then(doctors => {
        const doctorSelect = document.getElementById('doctor_id');
        doctorSelect.innerHTML = '';
        doctors.forEach(doctor => {
          doctorSelect.innerHTML += `<option value="${doctor.id}">${doctor.name}</option>`;
        });
      });
  }
</script>
@endsection
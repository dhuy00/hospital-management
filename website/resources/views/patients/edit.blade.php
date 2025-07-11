@extends('layouts.app')

@section('title', 'Chỉnh sửa bệnh nhân')

@section('content')
<form action="{{ route('patients.update', $patient['id']) }}" method="POST" class="bg-white p-6 rounded-lg shadow space-y-4">
  @csrf
  @method('PUT')

  <div>
    <label class="block font-medium mb-1">Tên đầy đủ</label>
    <input type="text" name="fullName" value="{{ old('fullName', $patient['fullName']) }}"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
    @error('fullName')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Email</label>
    <input type="email" name="email" value="{{ old('email', $patient['email']) }}"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
    @error('email')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Ngày sinh</label>
    <input type="date" name="dateOfBirth" value="{{ old('dateOfBirth', $patient['dateOfBirth']) }}"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
    @error('dateOfBirth')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Số điện thoại</label>
    <input type="text" name="phone" value="{{ old('phone', $patient['phone']) }}"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
    @error('phone')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Giới tính</label>
    <select name="gender" class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
      <option value="MALE" {{ old('gender', $patient['gender']) == 'MALE' ? 'selected' : '' }}>MALE</option>
      <option value="FEMALE" {{ old('gender', $patient['gender']) == 'FEMALE' ? 'selected' : '' }}>FEMALE</option>
      <option value="OTHER" {{ old('gender', $patient['gender']) == 'OTHER' ? 'selected' : '' }}>OTHER</option>
    </select>
    @error('gender')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Nhóm máu</label>
    <input type="text" name="bloodType" value="{{ old('bloodType', $patient['bloodType']) }}"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
    @error('bloodType')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Bệnh mãn tính</label>
    <textarea name="chronicDiseases" rows="2"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">{{ old('chronicDiseases', $patient['chronicDiseases']) }}</textarea>
    @error('chronicDiseases')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Dị ứng</label>
    <textarea name="allergies" rows="2"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">{{ old('allergies', $patient['allergies']) }}</textarea>
    @error('allergies')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Thuốc đang dùng</label>
    <textarea name="medications" rows="2"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">{{ old('medications', $patient['medications']) }}</textarea>
    @error('medications')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Người liên hệ khẩn cấp</label>
    <input type="text" name="emergencyContactName" value="{{ old('emergencyContactName', $patient['emergencyContactName']) }}"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
    @error('emergencyContactName')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Điện thoại khẩn cấp</label>
    <input type="text" name="emergencyContactPhone" value="{{ old('emergencyContactPhone', $patient['emergencyContactPhone']) }}"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
    @error('emergencyContactPhone')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Số bảo hiểm</label>
    <input type="text" name="insuranceNumber" value="{{ old('insuranceNumber', $patient['insuranceNumber']) }}"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
    @error('insuranceNumber')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Nghề nghiệp</label>
    <input type="text" name="occupation" value="{{ old('occupation', $patient['occupation']) }}"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
    @error('occupation')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block font-medium mb-1">Địa chỉ</label>
    <textarea name="address" rows="3"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300">{{ old('address', $patient['address']) }}</textarea>
    @error('address')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div class="flex space-x-2 pt-4 justify-end">
    <a href="{{ route('patients.show', $patient['id']) }}"
      class="px-4 py-2 rounded border-[2px] border-blue-500 hover:bg-blue-100 text-blue-500 transition">Hủy</a>
    <button type="submit"
      class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Lưu thay đổi</button>
  </div>
</form>
@endsection

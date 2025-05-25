import React, { useEffect, useState } from 'react'
import { FiEdit } from "react-icons/fi";
import Sidebar from './patient-info/Sidebar';
import { CiCircleMinus } from "react-icons/ci";

const InputField = ({ label, value, type, readOnly, onChange, width }) => {
  return (
    <div className='flex flex-col w-fit gap-2'>
      <label className='font-medium text-gray-400'>{label}</label>
      <input
        type={type}
        value={value}
        onChange={onChange}
        readOnly={readOnly}
        className={`${width ? "" : "w-fit"} py-[6px] text-gray-500 focus:outline-none 
        border-gray-600 border-[1px] border-solid rounded-md px-2`}
      />
    </div>
  );
};


const AddPatientExamination = (userRole) => {
  const [medicineNumber, setMedicineNumber] = useState(0);

  const handleAddMedicine = () => {
    setMedicineNumber(prev => prev + 1);
  }

  const handleRemoveMedicine = () => {
    setMedicineNumber(prev => prev - 1);
  }

  return (
    <div className='bg-white rounded-lg w-full h-full py-4 px-6 font-inter
    flex flex-col gap-4 '>
      {/* Header */}
      <h1 className='mt-2 font-semibold text-[1.6rem] text-gray-dark'>Thêm lịch sử khám bệnh</h1>
      {/* Divider */}
      <span className='w-full h-[2px] bg-gray-200'></span>
      {/* Info */}
      <div className='mt-2 gap-4 flex flex-row'>
        {/* Sidebar */}
        <Sidebar pathname='patient-history' id={1} />
        {/* Content */}
        <div className='flex flex-col gap-4 w-full'>
          <div className='flex flex-col overflow-y-auto max-h-[550px] gap-4 '>
            {/* Basic Medical Infomation */}
            <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
              {/* Administrative information */}
              <div className='flex flex-col justify-between font-bold gap-3'>
                <h3 className='text-gray-600 text-lg'>Thông tin hành chính</h3>
                {/* Input Field */}
                <div className='mt-2 grid grid-cols-2 gap-4'>
                  <InputField label="Mã bệnh nhân" />
                  <InputField label="Tên bệnh nhân" />
                  <InputField label="Ngày giờ khám" />
                  <InputField label="Loại khám" />
                  <InputField label="Tên bác sĩ" />
                </div>
              </div>
            </div>
            {/* Clinical information */}
            <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
              <div className='flex flex-col justify-between font-bold gap-3'>
                <h3 className='text-gray-600 text-lg'>Thông tin lâm sàng</h3>
                {/* Input Field */}
                <div className='mt-2 grid grid-cols-2 gap-4'>
                  <InputField label="Lý do khám" />
                  <InputField label="Triệu chứng" />
                  <InputField label="Nhiệt độ" />
                  <InputField label="Huyết áp" />
                  <InputField label="Mạch" />
                  <InputField label="Nhịp thở" />
                  <InputField label="Cân nặng" />
                  <InputField label="Chiều cao" />
                </div>
              </div>
            </div>
            {/* Tests and Diagnosis */}
            <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
              <div className='flex flex-col justify-between font-bold gap-3'>
                <h3 className='text-gray-600 text-lg'>Xét nghiệm và chẩn đoán</h3>
                {/* Input Field */}
                <div className='mt-2 grid grid-cols-2 gap-4'>
                  <InputField label="Yêu cầu xét nghiệm" />
                  <InputField label="Kết quả xét nghiệm" />
                  <InputField label="Chẩn đoán chính" />
                  <InputField label="Ghi chú" />
                </div>
              </div>
            </div>
            {/* Treatment */}
            <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
              <div className='flex flex-col justify-between font-bold'>
                <h3 className='text-gray-600 text-lg'>Điều trị</h3>
                {/* Input Field */}
                <div className='mt-2 gap-4'>
                  <div className='flex flex-col gap-2'>
                    <label className='text-gray-400 font-medium'>Tư vấn</label>
                    <textarea className='border-gray-600 border-[1px] border-solid
                    h-32 rounded-md p-2 focus:outline-none text-gray-400'>
                    </textarea>
                  </div>
                  <div className='flex flex-col gap-2'>
                    <label className='text-gray-400 font-medium'>Tư vấn</label>
                    <input
                      type='text'
                      className='border-gray-600 border-[1px] border-solid rounded-md
                    p-2 focus:outline-none text-gray-400'/>
                  </div>
                </div>
              </div>
            </div>
            {/* Prescription */}
            <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
              <div className='flex flex-col justify-between font-bold gap-2'>
                <div className='justify-between flex'>
                  <h3 className='text-gray-600 text-lg'>Đơn thuốc</h3>
                  <button className='px-6 py-[6px] bg-blue-500 text-white rounded-md
                  font-medium hover:bg-blue-600 transition-all'
                    onClick={handleAddMedicine}>
                    Thêm
                  </button>
                </div>
                {/* Input Field */}
                {[...Array(medicineNumber)].map((item, index) => (
                  <div className='flex flex-col relative'>
                    <span className='absolute right-4 top-5 cursor-pointer'>
                      <CiCircleMinus  style={{fontSize: "1.6rem"}} />
                    </span>
                    <div key={index} className='mt-2 grid grid-cols-3 gap-4 bg-slate-100 px-4 py-6
                    rounded-md'>
                      <InputField label="Tên thuốc" />
                      <InputField label="Liều lượng" />
                      <InputField label="Số lần uống mỗi ngày" />
                      <InputField label="Cách dùng" />
                      <InputField label="Ghi chú" />
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
          <button className='bg-indigo-500 w-fit px-4 py-2 text-white self-end
          rounded-md hover:bg-indigo-600 transition-all'>
            Xác nhận
          </button>
        </div>
      </div>
    </div>
  )
}

export default AddPatientExamination

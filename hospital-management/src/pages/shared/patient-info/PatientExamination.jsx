import React, { useEffect, useState } from 'react'
import { FiEdit } from "react-icons/fi";
import Sidebar from './Sidebar';

const InputField = ({ label, value = '', type, readOnly, onChange }) => {
  return (
    <div className='flex flex-col w-fit'>
      <label className='font-medium text-gray-400'>{label}</label>
      <input
        type={type}
        value={value}
        onChange={onChange}
        readOnly={readOnly}
        className='w-fit py-[4px] text-gray-medium focus:outline-none focus:border-none'
      />
    </div>
  );
};


const PatientExamination = (userRole) => {
  return (
    <div className='bg-white rounded-lg w-full h-full py-4 px-6 font-inter
    flex flex-col gap-4 '>
      {/* Header */}
      <h1 className='mt-2 font-semibold text-[1.6rem] text-gray-dark'>Thông tin bệnh nhân</h1>
      {/* Divider */}
      <span className='w-full h-[2px] bg-gray-200'></span>
      {/* Info */}
      <div className='mt-2 gap-4 flex flex-row'>
        {/* Sidebar */}
        <Sidebar pathname='patient-history' id={1} />
        {/* Content */}
        <div className='flex flex-col overflow-y-auto max-h-[550px] w-full gap-4 '>
          {/* Basic Medical Infomation */}
          <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
            {/* BHYT */}
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
          <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
            {/* BHYT */}
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
          <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
            {/* BHYT */}
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
          <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
            {/* BHYT */}
            <div className='flex flex-col justify-between font-bold gap-3'>
              <h3 className='text-gray-600 text-lg'>Điều trị</h3>
              {/* Input Field */}
              <div className='mt-2 grid grid-cols-2 gap-4'>
                <InputField label="Tư vấn" />
                <InputField label="Thủ thuật / Phẫu thuật (nếu có)" />
                <InputField label="Đơn thuốc" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

export default PatientExamination

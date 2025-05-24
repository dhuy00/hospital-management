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


const PatientPrescription = (userRole) => {
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
              <h3 className='text-gray-600 text-lg'>Thông tin chung</h3>
              {/* Input Field */}
              <div className='mt-2 grid grid-cols-2 gap-4'>
                <InputField label="Mã đơn thuốc" />
                <InputField label="Mã bệnh nhân" />
                <InputField label="Ngày kê đơn" />
                <InputField label="Bác sĩ kê đơn" />
                <InputField label="Khoa/phòng khám" />
              </div>
            </div>
          </div>
          <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
            {/* BHYT */}
            <div className='flex flex-col justify-between font-bold gap-3'>
              <h3 className='text-gray-600 text-lg'>Danh sách thuốc</h3>
              {/* Input Field */}
              <div className='mt-2 grid grid-cols-5 gap-4 text-gray-400'>
                <span>Tên thuốc</span>
                <span>Liều lượng</span>
                <span>Số lần uống mỗi ngày</span>
                <span>Cách dùng</span>
                <span>Ghi chú</span>
              </div>
              {[1, 2, 3, 4, 5].map((item, index) => (
                <div
                  key={index}
                  className='font-medium mt-2 grid grid-cols-5 gap-4 text-gray-700'
                >
                  <span>Paracetamol 500mg</span>
                  <span>1 viên/lần</span>
                  <span>3 lần/ngày</span>
                  <span>Uống sau ăn</span>
                  <span>Không dùng khi đau dạ dày</span>
                </div>
              ))}

            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

export default PatientPrescription

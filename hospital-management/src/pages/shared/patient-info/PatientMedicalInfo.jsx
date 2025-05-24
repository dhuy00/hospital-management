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


const PatientContact = (userRole) => {

  const [normalPhoneNumber, setNormalPhoneNumber] = useState([])

  const [urgentPhoneNumber, setUrgentPhoneNumber] = useState([])

  const [email, setEmail] = useState([])

  const [socialLink] = useState([
    {
      name: 'Facebook',
      link: 'facebook.com'
    },
    {
      name: 'Twitter',
      link: 'none'
    },
    {
      name: 'Linkedln',
      link: 'none'
    },

  ])


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
        <Sidebar pathname='patient-medical-info' id={1} />
        {/* Content */}
        <div className='flex flex-col overflow-y-auto max-h-[550px] w-full gap-4 '>
          {/* Basic Medical Infomation */}
          <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
            {/* BHYT */}
            <div className='flex flex-col justify-between font-bold gap-3'>
              <h3 className='text-gray-600 text-lg'>Bảo hiểm y tế (nếu có)</h3>
              {/* Input Field */}
              <div className='mt-2 grid grid-cols-2 gap-4'>
                <InputField label="Số thẻ BHYT" />
                <InputField label="Nơi đăng ký khám/chữa bệnh" />
                <InputField label="Ngày bắt đầu" />
                <InputField label="Ngày hết hạn" />
              </div>
            </div>
          </div>
          {/* Blood type */}
          <div className='pl-10  pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
            <div className='flex flex-col justify-between font-bold gap-3'>
              <h3 className='text-gray-600 text-lg'>Thông tin  y tế cơ bản</h3>
              {/* Input Field */}
              <div className='mt-2 grid grid-cols-2 gap-4'>
                <InputField label="Nhóm máu" />
                <InputField label="Tiền sử bệnh lý (bản thân & gia đình)" />
                <InputField label="Dị ứng thuốc/thực phẩm" />
                <InputField label="Tình trạng sức khỏe hiện tại" />
                <InputField label="Các bệnh mãn tính (nếu có)" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

export default PatientContact

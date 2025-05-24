import React, { useEffect, useState } from 'react'
import Sidebar from './Sidebar';

const InputField = ({ label, value, type }) => {
  return (
    <div className='flex flex-col w-fit'>
      <label className='font-medium text-gray-400'>{label}</label>
      <input type={type} value={value} className='outline-none w-fit py-[4px] text-gray-medium' readOnly={true} />
    </div>
  )
}

const Examination = ({}) => {
  return (
    <div className='pl-10 pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
      <div className='flex flex-row text-lg items-center justify-between font-bold text-gray-medium'>
        <h3>Chi tiết lần khám</h3>
      </div>
      {/* Input Field */}
      <div className='mt-2 grid grid-cols-3  gap-6'>
        <InputField label="Ngày khám" type="date" />
        <InputField label="Loại khám" type="text" />
        <InputField label="Lý do" type="text" />
        <InputField label="Triệu chứng" type="text" />
        <InputField label="Tên bác sĩ" type="date" />
        <div className='flex items-center gap-2'>
          <a href='/patient/examination/1' className='bg-blue-600 flex text-white
                 py-[8px] rounded-md text-md font-medium px-8 hover:bg-blue-700'>
            Chi tiết
          </a>
          <a href='/patient/prescription/1' className=' bg-green-600 flex justify-center text-white
                 py-[8px] rounded-md text-md font-medium px-8 hover:bg-green-700'>
            Đơn thuốc
          </a>
        </div>
      </div>
    </div>
  )
}

const PatientHistory = (userRole) => {

  const [workInfo, setWorkInfo] = useState({
    employeeID: '',
    manager: '',
    department: '',
    position: '',
    startDay: '',
    workType: ''
  })

  const [manager, setManager] = useState(null);
  // const [error2, setError] = useState(null);


  return (
    <div className='bg-white rounded-lg w-full h-full py-4 px-6 font-inter
    flex flex-col gap-4'>
      {/* Header */}
      <h1 className='mt-2 font-semibold text-[1.6rem] text-gray-dark'>Tài khoản</h1>
      {/* Divider */}
      <span className='w-full h-[2px] bg-gray-200'></span>
      {/* Info */}
      <div className='mt-2 gap-4 flex flex-row'>
        {/* Sidebar */}
        <Sidebar pathname='patient-history' id={1} />
        {/* Content */}
        <div className='flex flex-col overflow-y-auto max-h-[550px] w-full gap-4 '>
          {/* Patient Checkup History */}
          <Examination/>
          <Examination/>
          <Examination/>
          <Examination/>
        </div>
      </div>
    </div>
  )
}

export default PatientHistory

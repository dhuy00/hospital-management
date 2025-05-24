import React, { useState, useEffect } from 'react'
import { BiQrScan } from "react-icons/bi";
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


const PatientDetail = (userRole) => {

  const host = process.env.REACT_APP_API_URL;

  const [isReadOnly, setIsReadOnly] = useState(true);

  const [userInfo, setUserInfo] = useState({
    name: '',
    gender: '',
    birthday: '',
    nationality: '',
    position: '',
    role: userRole,
  });

  const [userAddress, setUserAddress] = useState('');
  const [userTempAddress, setUserTempAddress] = useState('');
  const [imageSrc, setImageSrc] = useState(null);

  // Hàm thay đổi readOnly khi nhấn nút
  const toggleReadOnly = () => {
    setIsReadOnly(!isReadOnly);
  };

  return (
    <div className='bg-white rounded-lg w-full h-full py-4 px-6 font-inter
    flex flex-col gap-4'>
      {/* Header */}
      <h1 className='mt-2 font-semibold text-[1.6rem] text-blue-950'>Tài khoản</h1>
      {/* Divider */}
      <span className='w-full h-[2px] bg-gray-200'></span>
      {/* Info */}
      <div className='mt-2 gap-4 flex flex-row'>
        {/* Sidebar */}
        <Sidebar pathname='patient-detail' id={1}/>
        {/* Content */}

        <div className='flex flex-col overflow-y-auto max-h-[550px] w-full gap-4 '>
          {/* Personal Info */}
          <div className='pl-10 pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
            <div className='flex flex-row text-lg items-center justify-between font-bold text-gray-600'>
              <h3>Thông tin cá nhân</h3>
              <FiEdit
                className='text-[1.5rem] cursor-pointer'
                onClick={toggleReadOnly}
              />
            </div>
            {/* Input Field */}
            <div className='mt-2 grid grid-cols-2 gap-4'>
              <InputField label="Tên" value={userInfo.name} type="text" readOnly={isReadOnly} onChange={(e) => setUserInfo({ ...userInfo, name: e.target.value })} />
              <InputField label="Giới tính" value={userInfo.gender} type="text" readOnly={isReadOnly} onChange={(e) => setUserInfo({ ...userInfo, gender: e.target.value })} />
              <InputField label="Ngày sinh" value={userInfo.birthday} type="date" readOnly={isReadOnly} onChange={(e) => setUserInfo({ ...userInfo, birthday: e.target.value })} />
              <InputField label="Quốc tịch" value={userInfo.nationality} type="text" readOnly={isReadOnly} onChange={(e) => setUserInfo({ ...userInfo, nationality: e.target.value })} />
              <InputField label="CCCD/CMND" value={userInfo.nationality} type="text" readOnly={isReadOnly} onChange={(e) => setUserInfo({ ...userInfo, nationality: e.target.value })} />
              <InputField label="Nghề nghiệp" value={userInfo.nationality} type="text" readOnly={isReadOnly} onChange={(e) => setUserInfo({ ...userInfo, nationality: e.target.value })} />
              <InputField label="Tình trạng hôn nhân" value={userInfo.nationality} type="text" readOnly={isReadOnly} onChange={(e) => setUserInfo({ ...userInfo, nationality: e.target.value })} />
            </div>
          </div>
          {/* Address Info */}
          <div className='pl-10 pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
            <div className='flex flex-row text-lg items-center justify-between font-bold text-gray-600'>
              <h3>Thông tin liên lạc</h3>
              <FiEdit className='text-[1.5rem]' />
            </div>
            {/* Input Field */}
            <div className='mt-2 grid grid-cols-2 gap-4'>
              <InputField label="Số điện thoại" value={userAddress.ward} type="text" readOnly={isReadOnly} onChange={(e) => setUserAddress({ ...userAddress, ward: e.target.value })} />
              <InputField label="Email (nếu có)" value={userAddress.district} type="text" readOnly={isReadOnly} onChange={(e) => setUserAddress({ ...userAddress, district: e.target.value })} />
              <InputField label="Địa chỉ thường trú" value={userAddress.street} type="text" readOnly={isReadOnly} onChange={(e) => setUserAddress({ ...userAddress, street: e.target.value })} />
              <InputField label="Địa chỉ tạm trú (nếu có)" value={userAddress.city} type="text" readOnly={isReadOnly} onChange={(e) => setUserAddress({ ...userAddress, city: e.target.value })} />
            </div>
          </div>
          {/* Temporary Address Info */}
          <div className='pl-10 pr-4 py-6 border-[2px] border-gray-light rounded-lg'>
            <div className='flex flex-row text-lg items-center justify-between font-bold text-gray-600'>
              <h3>Liên hệ người thân</h3>
              <FiEdit className='text-[1.5rem]' />
            </div>
            {/* Input Field */}
            <div className='mt-2 grid grid-cols-2 gap-4'>
              <InputField label="Họ tên người thân" value={userTempAddress.city} type="text" readOnly={isReadOnly} onChange={(e) => setUserTempAddress({ ...userTempAddress, city: e.target.value })} />
              <InputField label="Mối quan hệ" value={userTempAddress.district} type="text" readOnly={isReadOnly} onChange={(e) => setUserTempAddress({ ...userTempAddress, district: e.target.value })} />
              <InputField label="Thông tin liên lạc" value={userTempAddress.ward} type="text" readOnly={isReadOnly} onChange={(e) => setUserTempAddress({ ...userTempAddress, ward: e.target.value })} />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default PatientDetail;

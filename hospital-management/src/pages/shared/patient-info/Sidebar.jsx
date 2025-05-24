import React, { useEffect } from 'react'
import { Link } from 'react-router-dom';

const Sidebar = ({role, pathname, id}) => {

  useEffect(() => {
    console.log("role: ", role);
  }, [role])

  return (
    <div className='border-r-[1.5px] border-gray-light w-1/5'>
      <ul className='font-semibold text-gray-600 flex flex-col gap-8'>
        <Link to={`/patient/detail/${id}`} key={1}>
          <li className={`${pathname === 'patient-detail' ? 'border-r-[6px] border-blue-600 pr-12 py-3' : ''}`}>
            Thông tin cơ bản
          </li>
        </Link>
        <Link to={`/patient/medical-info/${id}`} key={2}>
          <li className={`${pathname === 'patient-medical-info' ? 'border-r-[6px] border-blue-600 pr-12 py-3' : ''}`}>
            Thông tin y tế
          </li>
        </Link>
        <Link to={`/patient/history/${id}`} key={3}>
          <li className={`${pathname === 'patient-history' ? 'border-r-[6px] border-blue-600 pr-12 py-3' : ''}`}>
            Lịch sử khám/chữa bệnh
          </li>
        </Link>
      </ul>
    </div>
  )
}

export default Sidebar

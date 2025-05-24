import React from 'react'
import { HiMenuAlt1 } from "react-icons/hi";
import { SiTheboringcompany } from "react-icons/si";
import { FiLogOut } from "react-icons/fi";
import { useLocation } from 'react-router-dom';
import { useState, useEffect } from 'react';
import { getAllNav } from '../navigation';
import { Link } from 'react-router-dom';
import { TbHospital } from "react-icons/tb"

const Sidebar = ({ roles }) => {
  const pathName = useLocation();
  // const basePath = pathName.pathname.split('/').slice(0, 3).join('/');

  const role = "doctor";

  const [allNav, setAllNav] = useState([]);

  const [userInfo, setUserInfo] = useState({
    userName: "loading...",
    email: "loading..."
  });

  const host = process.env.REACT_APP_API_URL;
  const [imageSrc, setImageSrc] = useState(null);


  useEffect(() => {
    const navs = getAllNav(role);
    setAllNav(navs);
  }, [role])

  useEffect(() => {
    console.log("Path name: ", pathName);
  }, [pathName])

  return (
    <div className='fixed top-4 left-4 flex flex-col justify-between 
    bottom-4 bg-white w-80 rounded-lg font-inter'>
      {/* Sidebar */}
      <div className='flex flex-col px-4 py-2'>
        {/* Sidebar Header */}
        <div className='flex flex-row justify-between items-center py-4'>
          <div className='flex gap-2 items-center'>
            <TbHospital
              style={{ fontSize: '2rem' }}
              className='cursor-pointer' />
            <span className='text-lg font-semibold text-slate-700'>
              Hospital
              </span>
          </div>
          <HiMenuAlt1
            style={{ fontSize: "1.5rem" }}
            className='cursor-pointer' />
        </div>
        {/* Navigation */}
        <ul className='flex flex-col gap-6 mr-4'>
          {
            allNav.map((nav, i) => (
              <Link to={nav.path} key={i}>
                <li key={i} className={` ${nav.path === pathName.pathname ? 'bg-blue-600 text-white' : 'text-slate-700'} transition-colors cursor-pointer  rounded-lg flex flex-row items-center gap-4 px-4 
                font-semibold py-3 hover:bg-blue-600 hover:text-white text-lg`}>
                  <span>{nav.icon}</span>
                  <span>{nav.title}</span>
                </li>
              </Link>
            ))
          }
        </ul>
      </div>
      {/* Logout */}
      <div className='bg-[#F8F8FA] w-full h-16 flex flex-row items-center 
      justify-center gap-2 rounded-b-lg'>
        {/* <img src={imageSrc || avatar} alt='img-avatar' className='rounded-full w-10 h-10' onError={(e) => e.target.src = avatar} /> */}
        <div>
          <p className='text-[13px]'>{userInfo.userName}</p>
          <p className='text-gray-500 text-[10px]'>{userInfo.email}</p>
        </div>
        <FiLogOut className='text-gray-500 ml-4 cursor-pointer' />
      </div>
    </div>
  )
}

export default Sidebar

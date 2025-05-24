import React, { useEffect, useState } from 'react'
import { Outlet } from 'react-router-dom'
import Sidebar from './Sidebar';

const MainLayout = () => {
    return (
        <div className=''>
            <Sidebar/>
            <div className='bg-[#F1F1F1] w-screen h-screen pl-[350px] pr-4 py-4'>
                <Outlet />
            </div>
        </div>
    )
}

export default MainLayout

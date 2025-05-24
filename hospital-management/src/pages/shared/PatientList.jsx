import React from 'react'
import { IoSearchSharp } from "react-icons/io5";
import { useState, useEffect } from 'react';
import { FaSort } from "react-icons/fa";
import { IoCheckmarkCircleOutline } from "react-icons/io5";
import { BsLightningChargeFill } from "react-icons/bs";
import { FaArrowRight, FaArrowLeft } from "react-icons/fa";
import { Link, useNavigate } from 'react-router-dom';
import { BiEditAlt } from "react-icons/bi";
import { RiDeleteBin6Line } from "react-icons/ri";


const PatientList = () => {

  const [row, setRow] = useState(5);
  const [data, setData] = useState([1, 2, 3, 4, 5, 6, 7, 8, 9]);
  const [showDialog, setShowDialog] = useState(false);

  const handleRowChange = (e) => {
    setRow(e.target.value);
  }

  const handleShowDialog = () => {
    setShowDialog(true);
  }

  return (
    <div className='bg-white rounded-lg w-full h-full py-4 px-6 font-inter flex flex-col gap-4 overflow-y-auto'>
      <div className='flex flex-row justify-between'>
        <div className='flex flex-col justify-center gap-2'>
          <h1 className='font-semibold text-3xl'>
            Danh sách bệnh nhân <span><BsLightningChargeFill className='text-yellow-500 inline' /></span>
          </h1>
          <span className='text-md text-gray-500 font-semibold'>
            Cập nhật lần cuối: 30/10/2024
          </span>
        </div>
      </div>
      {/* Divider */}
      <div className='flex'>
        <span className='w-full h-[1.4px] bg-gray-300'></span>
      </div>
      <div className='flex flex-col gap-4 bg-white rounded-[20px] mt-4'>
        <div className='flex flex-row justify-between items-center border-solid pb-1'>
          <div className='text-gray-medium text-md flex justify-end w-full'>
            <label>Rows per page: </label>
            <select name="rows" id="rows" value={row} onChange={(e) => handleRowChange(e)} className='w-8 outline-none focus:border-[2px] rounded-md focus:border-gray-medium'>
              {
                [1, 2, 3, 4, 5, 6, 7, 8, 9].map((d, i) =>
                  <option value={i}>{i}</option>
                )
              }
            </select>
          </div>
        </div>
        <div className=' w-full'>
          <table className='w-full font-medium text-[#526581]'>
            <thead className='w-full bg-gray-300'>
              <tr className='flex w-full gap-4 p-4'>
                <th className='w-[5%] text-left'>STT</th>
                <th className='w-[20%] text-left'>HỌ VÀ TÊN</th>
                <th className='w-[10%] text-left'>GIỚI TÍNH</th>
                <th className='w-[30%] text-left'>ĐỊA CHỈ</th>
                <th className='w-[15%] text-left'>CMND</th>
                <th className='w-[10%] text-left'>HÀNH ĐỘNG</th>
              </tr>
            </thead>
            <tbody className='w-full'>
              {
                data.slice(0, row).map((d, i) => <tr key={i} className='border-b-2 flex gap-4 items-center w-full py-4 cursor-pointer hover:bg-gray-200'>
                  <td className='w-[5%] text-left pl-4'>#1</td>
                  <td className='w-[20%] text-left'>Nguyễn Văn A</td>
                  <td className='w-[10%] text-left pl-4'>Nam</td>
                  <td className='w-[30%] text-left'>119 Bạch Đằng, Bình Thạnh</td>
                  <td className='w-[15%] text-left'>92374582357</td>
                  <td className='w-[10%] text-left'>
                    <a href='#' className='bg-blue-500 text-white rounded-md px-6 py-2 hover:bg-blue-600'>
                      Chi tiết
                    </a>
                  </td>
                </tr>)
              }
              <tr className='border-b-2 text-sm items-center h-12 flex justify-end'>
                <span>1 - {row} of {data.length}</span>
                <button className='mx-4'>
                  <i class="fa-solid fa-arrow-right"></i>
                </button>
                <button>
                  <i class="fa-solid fa-arrow-left"></i>
                </button>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  )
}

export default PatientList

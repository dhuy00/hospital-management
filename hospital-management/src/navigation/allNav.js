import { IoHomeOutline } from "react-icons/io5";
import { FaRegUser } from "react-icons/fa";
import { FaWpforms } from "react-icons/fa";
import { FaPlaneArrival } from "react-icons/fa";
import { FiGift } from "react-icons/fi";

export const allNav = [
  //Employee Navigation
  {
    id: 1,
    title: "Trang chủ",
    icon: <IoHomeOutline/>,
    role: 'admin',
    path: '/admin',
  },
  {
    id: 2,
    title: "Bệnh nhân",
    icon: <FaRegUser/>,
    role: 'doctor',
    path: '/patient',
  },
  {
    id: 3,
    title: "Lịch khám",
    icon: <FaWpforms/>,
    role: 'doctor',
    path: '/employee/form',
  },
  {
    id: 4,
    title: "Đơn thuốc",
    icon: <FaPlaneArrival/>,
    role: 'doctor',
    path: '/employee/activity',
  },
  {
    id: 5,
    title: "Thông báo",
    icon: <FiGift/>,
    role: 'doctor',
    path: '/employee/reward',
  },

]
import React from 'react'
import Lottie from 'lottie-react'
import loginAnimation from './../../assets/login-animation.json'
import InputField from '../../components/InputField'


const Login = () => {
  return (
    <div className='h-screen flex font-zenkaku'>
      {/* Illustration */}
      <div className='w-1/2 bg-blue-300 h-full flex justify-center items-center'>
        <Lottie
          animationData={loginAnimation}
          loop={true}
          style={{ height: 600, width: 600 }} />
      </div>
      {/* Login Form */}
      <div className='w-1/2 h-full flex justify-center items-center'>
        <form className='border-[#0179B4] border-[3px] border-solid px-12 py-8 rounded-lg
        gap-6 flex flex-col'>
          <h1 className="text-[2rem] font-bold bg-gradient-to-r from-[#30AFF6] to-[#516FD7] bg-clip-text text-transparent">
            Login to your account
          </h1>
          <InputField label="Username" type="text" placeholder="Enter your username" />
          <InputField label="Password" type="password" placeholder="Enter your username" />
          <button className="py-3 rounded-full text-white font-semibold text-lg tracking-widest bg-gradient-to-r from-[#30AFF6] to-[#516FD7] hover:from-[#289de0] hover:to-[#3f59c3] transition-all duration-300">
            Login
          </button>
          {/* Divider */}
          <div className='flex gap-4 justify-center items-center'>
            <span className='w-full h-[1px] bg-gray-500'></span>
            <span className='font-semibold text-gray-600'>Or</span>
            <span className='w-full h-[1px] bg-gray-500'></span>
          </div>
          {/* Register Button */}
          <div className="inline-block p-[3px] rounded-full bg-gradient-to-r from-[#30AFF6] to-[#516FD7] transition-all duration-300 hover:from-[#289de0] hover:to-[#3f59c3]">
            <button className="bg-white text-[#516FD7] font-semibold text-lg tracking-widest py-3 px-6 rounded-full w-full h-full hover:bg-[#def0ff] transition-all duration-300">
              Register
            </button>
          </div>

        </form>
      </div>
    </div>
  )
}

export default Login

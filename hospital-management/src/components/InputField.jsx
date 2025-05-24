import React from 'react'

const InputField = ({label, type, placeholder, value, onChange}) => {
  return (
    <div className='flex flex-col gap-2 text-lg'>
      <label className='text-gray-700 font-medium'>
        {label}
      </label>
      <input 
      className='border-gray-400 border-[1px] rounded-md px-4 py-2 w-96 outline-none
      focus:border-blue-500 transition-all' 
      type={type} 
      placeholder={placeholder}/>
    </div>
  )
}

export default InputField

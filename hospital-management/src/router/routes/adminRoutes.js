import Login from './../../pages/auth/Login';

const adminRoutes = [
  {
    path: '/admin/dashboard/',
    element: <Login/>,
    role: "admin"
  },
]

export default adminRoutes
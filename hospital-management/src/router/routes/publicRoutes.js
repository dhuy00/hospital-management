import Login from "../../pages/auth/Login";
import Register from "../../pages/auth/Register";


const publicRoutes = [
  {
    path: '/register',
    element: <Register/>,
  },
  {
    path: '/login',
    element: <Login/>
  },

]

export default publicRoutes
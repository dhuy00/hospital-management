import { Children } from "react";
import MainLayout from "../../layout/MainLayout";
import privateRoutes from "./privateRoutes";
import { Outlet } from "react-router-dom";

const getRoutes = () => {
  // privateRoutes.map(route => {
  // //  console.log(route);
  //    route.element = <ProtectedRoute route={route}>{route.element}</ProtectedRoute>
  // })


  return {
    path: '/',
    element: <MainLayout />,
    children: privateRoutes,
  }
}

export default getRoutes
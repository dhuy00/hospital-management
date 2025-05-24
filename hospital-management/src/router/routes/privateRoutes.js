import adminRoutes from "./adminRoutes";
import doctorRoutes from "./doctorRoutes";

const privateRoutes = [
  ...adminRoutes,
  ...doctorRoutes,
]

export default privateRoutes
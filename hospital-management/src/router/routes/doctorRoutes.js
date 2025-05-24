import Login from './../../pages/auth/Login';
import PatientList from '../../pages/shared/PatientList';
import PatientDetail from '../../pages/shared/patient-info/PatientDetail';
import PatientMedicalInfo from '../../pages/shared/patient-info/PatientMedicalInfo'
import PatientHistory from '../../pages/shared/patient-info/PatientHistory'
import PatientPrescription from '../../pages/shared/patient-info/PatientPrescription';
import PatientExamination from '../../pages/shared/patient-info/PatientExamination';

const doctorRoutes = [
  {
    path: '/patient',
    element: <PatientList/>,
    role: "doctor",
  },
  {
    path: '/patient/detail/:id',
    element: <PatientDetail/>,
    role: "doctor",
  },
  {
    path: '/patient/medical-info/:id',
    element: <PatientMedicalInfo/>,
    role: "doctor",
  },
  {
    path: '/patient/history/:id',
    element: <PatientHistory/>,
    role: "doctor",
  },
  {
    path: '/patient/examination/:id',
    element: <PatientExamination/>,
    role: "doctor",
  },
  {
    path: '/patient/prescription/:id',
    element: <PatientPrescription/>,
    role: "doctor",
  },
]

export default doctorRoutes
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Mock dữ liệu bệnh nhân theo tháng
        $patientsPerMonth = [
            '01/2025' => 120,
            '02/2025' => 135,
            '03/2025' => 98,
            '04/2025' => 142,
            '05/2025' => 167,
        ];

        // Mock dữ liệu đơn thuốc theo ngày
        $prescriptionsPerDay = [
            '01/07/2025' => 25,
            '02/07/2025' => 30,
            '03/07/2025' => 27,
            '04/07/2025' => 21,
            '05/07/2025' => 32,
        ];

        return view('reports.index', compact('patientsPerMonth', 'prescriptionsPerDay'));
    }
}

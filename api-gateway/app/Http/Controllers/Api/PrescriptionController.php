<?php


namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller; 


class PrescriptionController extends Controller
{
    public function getPrescriptionsByPatient($patientId)
    {
        try {
            $response = Http::get("http://localhost:5000/api/prescriptions/patient/{$patientId}");

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Failed to fetch prescriptions from API',
                    'status' => $response->status(),
                    'message' => $response->body(),
                ], $response->status());
            }

            return response()->json($response->json());

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

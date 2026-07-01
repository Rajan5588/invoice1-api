<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{
    public function getTemplate()
    {
        try {
            // Render the blade view into HTML string
          return view('BillTemplates.bill1');

       

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
               
            ], 500);
        }
    }
}

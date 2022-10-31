<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request) {
        return response()->json([
            "data"=>"Hello"
        ]);
    }
}

<?php

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HealthController extends Controller
{
    public function index(Request $reqeust): Response
    {
        return Inertia::render('Exams/Health/Index');
    }
}

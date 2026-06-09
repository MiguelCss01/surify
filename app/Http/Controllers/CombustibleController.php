<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CombustibleController extends Controller
{
    public function index()
    {
        return view('herramientas.combustible');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomesController extends Controller
{
    public function index(Request $request)
    {
        return view("homes/index");
    }
}

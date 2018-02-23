<?php

namespace App\Http\Controllers;

use App\ResDesign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResDesginController extends Controller
{
    public function index()
    {
        dd(ResDesign::listAllObjects('ssyl'));
    }
}

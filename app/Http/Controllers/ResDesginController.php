<?php

namespace App\Http\Controllers;

use App\ResDesign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResDesginController extends Controller
{
    public function index()
    {
        if (Auth::user()->ability('superadministrator', 'read-specials')){

        }
    }
}

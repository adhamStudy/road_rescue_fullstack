<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RequestServiceController extends Controller
{
    public function create()
    {

        return Inertia::render('RequestService');
    }
}

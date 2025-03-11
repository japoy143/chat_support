<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use function Termwind\render;

class AdminController extends Controller
{

    public function index()
    {
        return Inertia::render('admin/Dashboard');
    }


    public function users()
    {
        return Inertia::render('admin/User');
    }
}

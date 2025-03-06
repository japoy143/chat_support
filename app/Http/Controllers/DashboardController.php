<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard');
    }


    //set company background
    public function isset(Request $request)
    {
        $attribute = $request->validate([
            'company_background' => 'required|max:255'
        ]);

        $user_id = Auth::user()->id;

        $user = User::find($user_id);

        if ($user->update($attribute)) {
            $user->update(['is_company_background_set' => 1]);
        }

    }
}

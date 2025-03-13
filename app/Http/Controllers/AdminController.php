<?php

namespace App\Http\Controllers;

use App\Models\Daycreated;
use App\Models\Inquiries;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Termwind\render;

class AdminController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        return Inertia::render(
            'admin/Dashboard',
            [
                'all_users' => User::where('email', '!=', $user->email)->get(),
                'free_plan_users' => User::where('plans', '=', 'free')
                    ->where('email', '!=', $user->email)
                    ->get(),
                'business_plan_users' => User::where('plans', '=', 'business')->get(),
                'start_up_plan_users' => User::where('plans', '=', 'start up')->get(),
                'day_created' => Daycreated::find(1),
                'today' => Carbon::now()->dayOfWeek()
            ]
        );
    }


    public function users(Request $request)
    {
        $user = Auth::user();
        return Inertia::render('admin/User', [
            'all_users' => User::where('email', '!=', $user->email)
                ->when($request->search, function ($query) use ($request) {
                    $query->where('email', 'like', '%' . $request->search . '%');
                })
                ->get()
        ]);
    }



    public function subscribe(Request $request, $id)
    {
        $user = User::find($id);
        $plan = '';
        $token = 0;

        if ($request->plan === 'Business') {
            $plan = 'business';
            $token = 650;
        } else {
            $plan = 'start up';
            $token = 1000;
        }

        $user->update(['plans' => $plan, 'remaining_token_uses' => $token]);
    }



    public function inquiries(Request $request)
    {
        return Inertia::render('admin/Inquiries', [
            'all_inquiries' => Inquiries::when($request->search, function ($query) use ($request) {
                $query->where('email', 'like', '%' . $request->search . '%');
            })->get()
        ]);
    }


    public function statusUpdate(Request $request, Inquiries $inquiry)
    {
        $status = $request->input('data');

        $inquiry->update(['status' => $status]);
    }

}

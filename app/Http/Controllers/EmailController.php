<?php

namespace App\Http\Controllers;

use App\Mail\Subscription;
use App\Models\Inquiries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function sendSubscription(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:255',
            'plan' => 'required|string|max:255',
            'client_message' => 'string|max:255'
        ]);

        Inquiries::create(['email' => $request->email, 'plan' => $request->plan, 'message' => $request->client_message]);
        // Mail::to('joserizz143@gmail.com')->send(new Subscription($request->email, $request->plan, $request->client_message));
    }
}

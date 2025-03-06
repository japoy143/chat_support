<?php

namespace App\Http\Controllers;


use App\Services\DeepSeekService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use OpenAI;






class ChatSupportController extends Controller
{



    public function index()
    {
        return Inertia::render('ChatSupport');
    }


    public function chat(Request $request)
    {

        $apikey = config('services.openai.key');

        $client = OpenAI::client($apikey);

        $result = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'user', 'content' => $request->text],
            ],
        ]);

        dd($result->choices[0]->message->content);
    }

}

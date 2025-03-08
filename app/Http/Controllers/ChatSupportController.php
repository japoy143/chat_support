<?php

namespace App\Http\Controllers;

use App\Models\ApiKeyCounter;
use App\Models\Chat;
use App\Models\Tag;
use App\Services\DeepSeekService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use OpenAI;

use function Pest\Laravel\json;

class ChatSupportController extends Controller
{



    public function index()
    {
        return Inertia::render('ChatSupport');
    }


    public function chat(Request $request)
    {
        $text = $request->input('text');
        //choose an api key to prevent traffic
        $apiKeyCount = ApiKeyCounter::find(1);
        //counter for usage api whether apikey 1 - 3
        $currentApiKeyCount = $apiKeyCount->count;

        $apikey = '';
        switch ($currentApiKeyCount) {
            case 0;
                $apikey = config('services.openai.key1');
                $increment = $currentApiKeyCount + 1;
                $apiKeyCount->update(['count' => $increment]);
                break;
            case 1;
                $apikey = config('services.openai.key2');
                $increment = $currentApiKeyCount + 1;
                $apiKeyCount->update(['count' => $increment]);
                break;
            case 2;
                $apikey = config('services.openai.key3');
                $apiKeyCount->update(['count' => 0]);
                break;
            default;
                $apikey = config('services.openai.key1');
        }


        //find related response using tags
        $splitted_text = explode(' ', $text);
        //get tags
        $tags = Tag::all();
        //to lowercase
        $tags = $tags->map(function ($tag) {
            $tag->tagname = strtolower($tag->tagname);
            return $tag;
        });

        //getting related tags
        $related_tags = [];
        foreach ($splitted_text as $word) {
            $word = strtolower($word);


            if ($tags->contains('tagname', $word)) {
                $related_tags[] = ucfirst($word);
            }
        }

        $chat_response = Chat::whereHas('tags', function ($query) use ($related_tags) {
            $query->whereIn('tagname', $related_tags); // Ensure $tags is a flat array
        })->first();



        //for script
        $owner = Auth::user();
        $script = 'Company Response:' . $chat_response->chat_scripts . 'Website Url:' . 'ww.rainshop.com' . 'Contact:' . '09285320274' . 'Your Name:' . $owner->email . 'Company Background:' . $owner->company_background . 'make the response like it personal and based on company ';
        $request->validate([
            'text' => 'required|string|max:255'
        ]);



        try {
            $client = OpenAI::client($apikey);

            $result = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'user', 'content' => $script . $text],
                ],
            ]);

            return response()->json([
                'message' => $result->choices[0]->message->content
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to communicate with OpenAI API',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    //chat support api

    public function chatSupportApi($prompt)
    {
        //prevent empty query
        if ($prompt === '') {
            return response()->json('Error please provide prompt');
        }


        $apikey = config('services.openai.key1');

        try {
            $client = OpenAI::client($apikey);

            $result = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            return response()->json([
                'message' => $result->choices[0]->message->content
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to communicate with OpenAI API',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}

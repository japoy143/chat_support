<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use OpenAI;
use function Termwind\render;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Chats', [
            'chats' => Chat::all()
                ->filter(fn($item) => Gate::allows('view', $item))
                ->map(function ($chat) {
                    return [
                        'id' => $chat->id,
                        'chat_scripts' => $chat->chat_scripts,
                        'user_id' => $chat->user_id,
                        'created_at' => $chat->created_at,
                        'updated_at' => $chat->updated_at,
                        'tags' => $chat->tags,
                    ];
                }),
            'tags' => Tag::when($request->search, function ($query) use ($request) {
                $query->where('tagname', 'like', '%' . $request->search . '%');
            })->get()
                ->filter(fn($item) => Gate::allows('view', $item))

        ]);
    }


    //store chat scripts
    public function store(Request $request)
    {

        //validation
        $attributes = $request->validate([
            'chat_scripts' => 'required|max:255',

        ]);

        $attributes['user_id'] = Auth::id();



        //save
        $chat_script = Chat::create($attributes);


        foreach ($request->tags as $tag) {
            $chat_script->tags()->attach($tag['id']);
        }

    }


    public function delete(Chat $chat)
    {
        $chat->delete();
    }



    //gpt

}

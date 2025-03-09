<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Tags', [


            'tags' => Tag::when($request->search, function ($query) use ($request) {
                $query->where('tagname', 'like', '%' . $request->search . '%');
            })->get()
                ->filter(fn($item) => Gate::allows('view', $item))
                ->map(function ($tag) {
                    return [
                        'id' => $tag->id,
                        'tagname' => $tag->tagname,
                        'user_id' => $tag->user_id,
                        'created_at' => $tag->created_at,
                        'updated_at' => $tag->updated_at,
                        'associated_chats' => $tag->chats,
                    ];
                })
        ]);
    }


    public function store(Request $request)
    {
        //validate
        $attributes = $request->validate([
            'tagname' => 'required|max:255',

        ]);

        $attributes['tagname'] = ucfirst($request->tagname);

        $attributes['user_id'] = Auth::id();
        //added tag
        Tag::create($attributes);

    }


    public function delete(Tag $tag)
    {
        $tag->delete();
    }
}

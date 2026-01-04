<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function show($post) {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:10',
        ]);

        $request->user()->posts()->create($validated);


        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit($post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $post)
    {
        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:10',
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}

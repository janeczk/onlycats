<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function index(): View
    {
        return view('comment.index')->with('comments', Comment::all());
    }

    public function show(Comment $comment): View
    {
        return view('comment.show')->with('comment', $comment);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'text' => 'required|max:255',
            'post_id' => 'required|exists:posts,id',
        ]);

        // Tworzenie komentarza
        Comment::create([
            'text' => $request->text,
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
        ]);

        $referer = $request->input('referer', 'home');

        return redirect()->route('posts.show', ['post' => $request->post_id, 'referer' => $referer])
            ->with('success', 'Comment added!');
    }


    public function destroy(Comment $comment): RedirectResponse
    {
        if (auth()->id() !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }


}

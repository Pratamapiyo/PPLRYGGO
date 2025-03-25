<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Like;

class DiscussionController extends Controller
{
    public function index()
    {
        $discussions = Discussion::with('user')->latest()->get();
        return view('forum', compact('discussions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        Discussion::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('forum')->with('success', 'Discussion created successfully!');
    }

    public function reply(Request $request, $discussionId)
    {
        $request->validate([
            'body' => 'required',
        ]);

        Reply::create([
            'discussion_id' => $discussionId,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return redirect()->route('forum')->with('success', 'Reply added successfully!');
    }

    public function like($discussionId)
    {
        $discussion = Discussion::findOrFail($discussionId);

        // Check if the user already liked the discussion
        if ($discussion->likes()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('forum')->with('error', 'You already liked this discussion.');
        }

        $discussion->likes()->create([
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('forum')->with('success', 'Discussion liked successfully!');
    }
}

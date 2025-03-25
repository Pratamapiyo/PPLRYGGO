<?php
namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Http\Request;

class AdminForumController extends Controller
{
    public function index()
    {
        $discussions = Discussion::with(['user', 'replies.user'])->latest()->get();
        return view('Admin-forum', compact('discussions'));
    }

    public function deleteDiscussion(Discussion $discussion)
    {
        $discussion->delete();
        return redirect()->route('admin.forum.manage')->with('success', 'Discussion deleted successfully!');
    }

    public function deleteReply(Reply $reply)
    {
        $reply->delete();
        return redirect()->route('admin.forum.manage')->with('success', 'Reply deleted successfully!');
    }
}

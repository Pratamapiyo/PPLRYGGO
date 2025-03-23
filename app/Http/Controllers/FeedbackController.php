<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Redirect back to the feedback page with a success message
        return redirect()->route('feedbacks.index')->with('success', 'Feedback berhasil dikirim.');
    }

    public function index()
    {
        $feedbacks = Feedback::with('user')->latest()->get();
        return view('feedback', compact('feedbacks')); // Pass feedbacks to the view
    }

    public function userFeedbacks()
    {
        $feedbacks = Feedback::where('user_id', Auth::id())->latest()->get();
        return view('myfeedback', compact('feedbacks')); // Pass user feedbacks to the view
    }
}

@extends('layouts.layout')

@section('title', 'Forum')

@section('content')
<section class="forum-section section-padding" id="section_forum">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Form Section -->
            <div class="col-lg-8 col-12 mb-4">
                <div class="card card-custom shadow-sm border-1">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Create a New Discussion</h5>
                    </div>
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('forum.create') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter discussion title" required>
                            </div>
                            <div class="mb-3">
                                <label for="body" class="form-label">Body</label>
                                <textarea class="form-control" id="body" name="body" rows="4" placeholder="Write your discussion content here..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Create Discussion</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Discussions List Section -->
            <div class="col-lg-8 col-12">
                <div class="card card-custom shadow-sm border-1">
                    <div class="d-flex justify-content-between align-items-center p-3 text-white rounded-top">
                        <h5 class="mb-0">All Discussions</h5>
                    </div>
                    <div class="card-body p-5">
                        @if ($discussions->isEmpty())
                        <p class="text-center">No discussions yet. Be the first to start one!</p>
                        @else
                        <ul class="list-group">
                            @foreach ($discussions as $discussion)
                            <li class="list-group-item">
                                <h5>{{ $discussion->title }}</h5>
                                <p>{{ $discussion->body }}</p>
                                <small class="text-muted">By {{ $discussion->user->name }} on {{ $discussion->created_at->format('d M Y, H:i') }}</small>
                                <div class="mt-2">
                                    <!-- Like Button -->
                                    <form method="POST" action="{{ route('forum.like', $discussion->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            Like ({{ $discussion->likes->count() }})
                                        </button>
                                    </form>
                                </div>
                                <hr>
                                <!-- Replies Section -->
                                <h6>Replies:</h6>
                                <ul>
                                    @foreach ($discussion->replies as $reply)
                                    <li>
                                        <strong>{{ $reply->user->name }}</strong>: {{ $reply->body }}
                                        <br>
                                        <small class="text-muted">{{ $reply->created_at->format('d M Y, H:i') }}</small>
                                    </li>
                                    @endforeach
                                </ul>
                                <!-- Reply Button -->
                                <button class="btn btn-link btn-sm mt-2" onclick="toggleReplyForm({{ $discussion->id }})">Reply</button>
                                <!-- Reply Form -->
                                <form method="POST" action="{{ route('forum.reply', $discussion->id) }}" class="mt-3 d-none" id="reply-form-{{ $discussion->id }}">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control" name="body" rows="2" placeholder="Write your reply..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-secondary btn-sm">Submit Reply</button>
                                </form>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function toggleReplyForm(discussionId) {
        const form = document.getElementById(`reply-form-${discussionId}`);
        form.classList.toggle('d-none');
    }
</script>
@endsection
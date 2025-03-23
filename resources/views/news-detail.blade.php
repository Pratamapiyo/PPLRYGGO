@extends('layouts.layout')

@section('title', $news->title)

@section('content')

<main>
    <section class="news-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-12 mx-auto">
                    <div class="news-block">
                        <div class="news-block-top">
                            <img src="{{ $news->image ? asset('storage/' . $news->image) : 'https://picsum.photos/seed/' . urlencode($news->title) . '/600/400' }}" class="news-image img-fluid" alt="{{ $news->title }}">
                            @if($news->categories->isNotEmpty())
                            <div class="news-category-block">
                                @foreach($news->categories as $category)
                                <a href="#" class="category-block-link">
                                    {{ $category->name }}{{ !$loop->last ? ',' : '' }}
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="news-block-info">
                            <div class="d-flex mt-2">
                                <div class="news-block-date">
                                    <p>
                                        <i class="bi-calendar4 custom-icon me-1"></i>
                                        {{ $news->published_at->format('F d, Y') }}
                                    </p>
                                </div>
                                <div class="news-block-author mx-5">
                                    <p>
                                        <i class="bi-person custom-icon me-1"></i>
                                        By {{ $news->author->name }}
                                    </p>
                                </div>
                            </div>
                            <div class="news-block-title mb-2">
                                <h4>{{ $news->title }}</h4>
                            </div>
                            <div class="news-block-body">
                                <p>{!! nl2br(e($news->body)) !!}</p>
                            </div>

                            <div class="row mt-5 mb-4">
                                <div class="col-lg-6 col-12 mb-4 mb-lg-0">
                                    <img src="{{ $news->image_1 ? asset('storage/' . $news->image_1) : 'https://picsum.photos/seed/' . urlencode($news->title . '-1') . '/600/400' }}" class="news-detail-image img-fluid" alt="Image 1">
                                </div>
                                <div class="col-lg-6 col-12">
                                    <img src="{{ $news->image_2 ? asset('storage/' . $news->image_2) : 'https://picsum.photos/seed/' . urlencode($news->title . '-2') . '/600/400' }}" class="news-detail-image img-fluid" alt="Image 2">
                                </div>
                            </div>

                            @if($news->tags->isNotEmpty())
                            <div class="tags-block border-top mt-5 py-4">
                                <h6>Tags:</h6>
                                @foreach($news->tags as $tag)
                                <a href="#" class="tags-block-link">
                                    {{ $tag->name }}
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($relatedNews->isNotEmpty())
    <section class="news-section section-padding section-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 mb-4">
                    <h2>Related News</h2>
                </div>

                @foreach($relatedNews as $related)
                <div class="col-lg-6 col-12">
                    <div class="news-block">
                        <div class="news-block-top">
                            <a href="{{ route('econews.detail', ['id' => $related->id]) }}">
                                <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://picsum.photos/seed/' . urlencode($related->title) . '/600/400' }}" class="news-image img-fluid" alt="{{ $related->title }}">
                            </a>
                            @if($related->categories->isNotEmpty())
                            <div class="news-category-block">
                                @foreach($related->categories as $category)
                                <a href="#" class="category-block-link">
                                    {{ $category->name }}{{ !$loop->last ? ',' : '' }}
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="news-block-info">
                            <div class="d-flex mt-2">
                                <div class="news-block-date">
                                    <p>
                                        <i class="bi-calendar4 custom-icon me-1"></i>
                                        {{ $related->published_at->format('F d, Y') }}
                                    </p>
                                </div>
                                <div class="news-block-author mx-5">
                                    <p>
                                        <i class="bi-person custom-icon me-1"></i>
                                        By {{ $related->author->name }}
                                    </p>
                                </div>
                            </div>
                            <div class="news-block-title mb-2">
                                <h4><a href="{{ route('econews.detail', ['id' => $related->id]) }}" class="news-block-title-link">{{ $related->title }}</a></h4>
                            </div>
                            <div class="news-block-body">
                                <p>{{ Str::limit($related->body, 100) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</main>

@endsection
@extends('layouts.layout')

@section('title', 'Eco News')

@section('content')

<main>

    <section class="news-detail-header-section text-center">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12">
                    <h1 class="text-white">Eco News</h1>
                </div>

            </div>
        </div>
    </section>

    <section class="news-section section-padding">
        <div class="container">
            <div class="row">

                <div class="col-lg-7 col-12">
                    @foreach($newsItems as $news)
                    <div class="news-block">
                        <div class="news-block-top">
                            <a href="{{ route('econews.detail', ['id' => $news->id]) }}">
                                <img src="{{ $news->image ? asset('storage/' . $news->image) : 'https://picsum.photos/seed/' . urlencode($news->title) . '/600/400' }}" class="news-image img-fluid" alt="{{ $news->title }}" style="width: 100%; height: 400px; object-fit: none;">
                            </a>

                            <div class="news-category-block">
                                @foreach($news->categories as $category)
                                <a href="{{ route('econews.filter.category', ['id' => $category->id]) }}" class="category-block-link">
                                    {{ $category->name }}{{ !$loop->last ? ',' : '' }}
                                </a>
                                @endforeach
                            </div>
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

                                <div class="news-block-comment">
                                    <p>
                                        <i class="bi-chat-left custom-icon me-1"></i>
                                        {{ $news->comments_count ?? 0 }} Comments
                                    </p>
                                </div>
                            </div>

                            <div class="news-block-title mb-2">
                                <h4><a href="{{ route('econews.detail', ['id' => $news->id]) }}" class="news-block-title-link">{{ $news->title }}</a></h4>
                            </div>

                            <div class="news-block-body">
                                <p>{{ Str::limit($news->body, 150) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="col-lg-4 col-12 mx-auto mt-4 mt-lg-0">
                    <form class="custom-form search-form" action="#" method="post" role="form">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">

                        <button type="submit" class="form-control">
                            <i class="bi-search"></i>
                        </button>
                    </form>

                    <h5 class="mt-5 mb-3">Recent news</h5>

                    @foreach($recentNews->take(3) as $recent)
                    <div class="news-block news-block-two-col d-flex mt-4">
                        <div class="news-block-two-col-image-wrap">
                            <a href="{{ route('econews.detail', ['id' => $recent->id]) }}">
                                <img src="{{ $recent->image ? asset('storage/' . $recent->image) : 'https://picsum.photos/seed/' . urlencode($recent->title) . '/100/100' }}" class="news-image img-fluid" alt="{{ $recent->title }}" style="width: 100%; height: 100px; object-fit: cover;">
                            </a>
                        </div>

                        <div class="news-block-two-col-info">
                            <div class="news-block-title mb-2">
                                <h6><a href="{{ route('econews.detail', ['id' => $recent->id]) }}" class="news-block-title-link">{{ $recent->title }}</a></h6>
                            </div>

                            <div class="news-block-date">
                                <p>
                                    <i class="bi-calendar4 custom-icon me-1"></i>
                                    {{ $recent->published_at->format('F d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="category-block d-flex flex-column">
                        <h5 class="mb-3">Categories</h5>

                        @foreach($categories as $category)
                        <a href="{{ route('econews.filter.category', ['id' => $category->id]) }}" class="category-block-link {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'active' : '' }}">
                            {{ $category->name }}
                            <span class="badge">{{ $category->news_count }}</span>
                        </a>
                        @endforeach

                        @if(isset($selectedCategory))
                        <a href="{{ route('econews') }}" class="category-block-link text-danger mt-2">Clear Categories</a>
                        @endif
                    </div>

                    <div class="tags-block">
                        <h5 class="mb-3">Tags</h5>

                        @foreach($tags as $tag)
                        <a href="{{ route('econews.filter.tag', ['id' => $tag->id]) }}" class="tags-block-link {{ isset($selectedTag) && $selectedTag->id == $tag->id ? 'active' : '' }}">
                            {{ $tag->name }}
                        </a>
                        @endforeach

                        @if(isset($selectedTag))
                        <a href="{{ route('econews') }}" class="tags-block-link text-danger mt-2">Clear Tags</a>
                        @endif
                    </div>

                    @if(isset($selectedTag) || isset($selectedCategory))
                    <div style="text-align: center; margin-top: 20px;">
                        <button style="border: 1px solid #dc3545; color: #dc3545; background-color: transparent; padding: 10px 20px; border-radius: 5px; cursor: pointer;" onclick="window.location='{{ route('econews') }}'">
                            Clear All Tags and Categories
                        </button>
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </section>
</main>

@endsection
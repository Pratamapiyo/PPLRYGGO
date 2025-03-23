@extends('layouts.adminlayout')

@section('title', 'Admin EcoNews')

@section('content')

<main class="main-content bgc-grey-100">
    <div id="mainContent">
        <div class="container-fluid">
            <h4 class="c-grey-900 mT-10 mB-30">Manajemen EcoNews</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Daftar Berita</h4>
                        <a href="{{ route('admin.econews.create') }}" class="btn btn-success mB-20">Tambah Berita</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Penulis</th>
                                    <th scope="col">Tanggal Publikasi</th>
                                    <th scope="col">Tags</th>
                                    <th scope="col">Categories</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newsItems as $index => $news)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $news->title }}</td>
                                        <td>{{ $news->author->name }}</td>
                                        <td>{{ $news->published_at->format('d M Y') }}</td>
                                        <td>
                                            @foreach ($news->tags as $tag)
                                                <span class="badge bg-primary">{{ $tag->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($news->categories as $category)
                                                <span class="badge bg-secondary">{{ $category->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="gap-10 peers">
                                                <div class="peer">
                                                    <a href="{{ route('econews.detail', $news->id) }}" class="btn cur-p btn-info btn-color">View</a>
                                                </div>
                                                <div class="peer">
                                                    <a href="{{ route('admin.econews.edit', $news->id) }}" class="btn cur-p btn-primary btn-color">Edit</a>
                                                </div>
                                                <div class="peer">
                                                    <form action="{{ route('admin.econews.update', $news->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn cur-p btn-danger btn-color" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
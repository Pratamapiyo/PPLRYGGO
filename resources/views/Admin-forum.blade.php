@extends('layouts.adminlayout')

@section('title', 'Manajemen Forum')

@section('content')
<main class="main-content bgc-grey-100">
    <div id="mainContent">
        <div class="container-fluid">
            <h4 class="c-grey-900 mT-10 mB-30">Manajemen Forum</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Daftar Diskusi</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Judul Diskusi</th>
                                    <th scope="col">Pengguna</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discussions as $index => $discussion)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $discussion->title }}</td>
                                        <td>{{ $discussion->user->name }}</td>
                                        <td>{{ $discussion->created_at->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('admin.forum.discussion.delete', $discussion->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn cur-p btn-danger btn-color" onclick="return confirm('Are you sure you want to delete this discussion?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Replies Section -->
                                    @if ($discussion->replies->isNotEmpty())
                                        <tr>
                                            <td colspan="5">
                                                <strong>Replies:</strong>
                                                <ul>
                                                    @foreach ($discussion->replies as $reply)
                                                        <li>
                                                            <strong>{{ $reply->user->name }}</strong>: {{ $reply->body }}
                                                            <br>
                                                            <small class="text-muted">{{ $reply->created_at->format('d-m-Y H:i') }}</small>
                                                            <form action="{{ route('admin.forum.reply.delete', $reply->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger btn-color" onclick="return confirm('Are you sure you want to delete this reply?')">Delete</button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endif
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

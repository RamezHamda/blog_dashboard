@extends('admin.master')
@section('title', 'Trashed Posts | ' . env('APP_NAME'))


@section('styles')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <style>
        .table th,
        .table td {
            vertical-align: middle
        }
    </style>
@stop
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Trashed posts</h1>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger">
            {{ session('delete') }}
        </div>
    @endif

    <a class="btn btn-primary" href="{{ route('admin.posts.index') }}">All Posts</a>
    <table class="table table-bordered table-hover table-striped">
        <tr class="bg-dark text-white">
            <th>ID</th>
            <th>Title</th>
            <th>Deleted By</th>
            <th>Deleted At</th>
            <th>Action</th>
        </tr>

        @forelse ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->deleted_by }}</td>
                <td>{{ $post->deleted_at->diffForHumans() }}</td>

                <td>
                    <a href="{{ route('admin.posts.restore', $post->id) }}" class="btn btn-primary btn-sm"><i
                            class="fas fa-undo"></i></a>

                    <a href="{{ route('admin.posts.forcedelete', $post->id) }}" class="btn btn-danger btn-sm"><i
                            class="fas fa-times"></i></a>



                    {{-- <form class="d-inline" action="{{ route('admin.posts.restore', $post->id) }}" method="post">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-times"></i></button>
                    </form> --}}

                    {{-- <form class="d-inline" action="{{ route('admin.posts.forcedelete', $post->id) }}" method="post">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                    </form> --}}

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No Data Found</td>
            </tr>
        @endforelse

    </table>

    {{ $posts->links() }}
@endsection

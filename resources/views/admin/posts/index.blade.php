@extends('admin.master')
@section('title', "All Posts | " . env("APP_NAME") )

@push('styles')
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}
<style>
    .table th,
    .table td{
        vertical-align: middle
    }
</style>
@endpush
@section('content')
<h1 class="h3 mb-4 text-gray-800">All posts</h1>

@if (session()->has('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if (session()->has('delete'))
    <div class="alert alert-danger">
        {{session('delete')}}
    </div>
@endif

<form id="search-form" method="GET" action="{{route("admin.posts.index")}}">
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="search" placeholder="Search here.." value="{{request()->search}}">
        <select name="count" onchange="document.getElementById('search-form').submit()">
            <option {{request()->count == 10 ? 'selected' : ''}} value="10">10</option>
            <option {{request()->count == 20 ? 'selected' : ''}} value="20">20</option>
            <option {{request()->count == 30 ? 'selected' : ''}} value="30">30</option>
            <option @selected(request()->count == $posts->total()) value="{{$posts->total()}}">All</option>
        </select>
        <div class="input-group-append">
            <button class="btn btn-dark px-4" id="button" type="submit">Search</button>
        </div>
    </div>
</form>

<table class="table table-bordered table-hover table-striped">
    <tr class="bg-dark text-white">
        <th>ID</th>
        <th>Title</th>
        <th>Image</th>
        <th>User</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Action</th>
    </tr>

    @forelse ($posts as $post)
    <tr>
        <td>{{$post->id}}</td>
        <td>{{$post->title}}</td>
        <td><img width="100" src="{{$post->image_url }}" alt=""></td>
        <td>{{$post->user_id}}</td>
        <td>{{$post->created_at->format('F d ,Y')}}</td>
        <td>{{$post->updated_at->diffForHumans()}}</td>

        <td>
            {{-- <a href="#" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a> --}}
            <a href="{{route('admin.posts.edit',$post->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>

            <form class="d-inline" action="{{route('admin.posts.destroy',$post->id)}}" method="post">
                @csrf
                @method('delete')

                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
            </form>

        </td>
    </tr>
    @empty
        <tr>
            <td colspan="7">No Data Found</td>
        </tr>
    @endforelse

</table>

{{ $posts->appends(['search' => request()->search  ,'count' => request()->count ])->links()}}
@endsection


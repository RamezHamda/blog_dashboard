@extends('admin.master')
@section('title', "Edit Post | " . env("APP_NAME") )


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
<h1 class="h3 mb-4 text-gray-800">Edit Post</h1>
{{-- @dump($errors) --}}
{{-- @dump($errors->any()) --}}
{{-- @dump($errors->all()) --}}

@include('admin.errors')



<form action="{{route('admin.posts.update',$post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"  value="{{old('title',$post->title)}}">
        @error('title')
            <small class="invalid-feedback">{{$message}}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label> Image</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
        @error('image')
        <small class="invalid-feedback">{{$message}}</small>
        @enderror
        <img width="100" src="{{asset('uploads/'.$post->image)}}" alt="">
    </div>

    <div class="mb-3">
        <label>Content</label>
        <textarea name="content" class="form-control @error('content') is-invalid @enderror"  id="textarea" rows="5">
            {{old('content',$post->content)}}
        </textarea>
        @error('content')
        <small class="invalid-feedback">{{$message}}</small>
        @enderror
    </div>

    <button class="btn btn-success px-5" type="submit">Edit</button>
</form>

@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.2.0/tinymce.min.js" ></script>
<script>
    tinymce.init({
      selector: '#textarea',
      plugins: ['code']
    });
  </script>
@endpush

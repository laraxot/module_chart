@extends('_layouts.master')
 
@section('body')
    <h1>Doc Posts</h1>
    {{-- $page --}}
    @foreach ($docs as $post)
        <h2><a href="{{ $post->getPath() }}">{{ $post->title }}</a></h2>
        <h3>By {{ $post->author }}</h3>
        {{ $post->getContent() }}
    @endforeach
@endsection
@extends('_layouts.master')
 
@section('body')
    iiiiiiii
    <h1>{{ $page->title }}</h1>
    <p>by {{ $page->author }}</p>
 
    @yield('postContent')
@endsection
@extends('adm_theme::layouts.app')
@section('content')
    <x-navbar>
        @foreach ($drivers as $k => $v)
            <x-navbar.item href="{!! Request::fullUrlWithQuery(['i' => $k]) !!}" active="{{ $driver == $v ? 'active' : '' }}">
                {{ $v }}
            </x-navbar.item>
        @endforeach
    </x-navbar>


    <x-col size="6">
        @if ($driver !== null)
            @include($view.'.'.$driver)
        @endif
    </x-col>

@endsection

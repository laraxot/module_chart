<!DOCTYPE html>
<html lang="{{ $lang }}">
@section('htmlheader')
    @include('chart::layouts.partials.htmlheader')
@show

<body {!! isset($body_style) ? 'style="' . $body_style . '"' : '' !!}>
    @yield('body')
    @section('scripts')
        @include('chart::layouts.partials.scripts')
    @show
</body>

</html>

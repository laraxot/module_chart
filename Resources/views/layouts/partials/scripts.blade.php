<script>
    var base_url = '{{ asset('/') }}';
    var lang = '{{ app()->getLocale() }}';
   
    @if (\Request::has('address'))
        var address = "{{ \Request::input('address') }}";
    @endif
    @if (\Request::has('lat') && \Request::has('lng'))
        var lat = "{{ \Request::input('lat') }}";
        var lng = "{{ \Request::input('lng') }}";
    @endif
</script>
@stack('scripts_before')
@php
Theme::add('pub_theme::dist/js/manifest.js');
Theme::add('pub_theme::dist/js/vendor.js');
Theme::add('pub_theme::dist/js/app.js');
//Theme::add('pub_theme::js/theme.js');
@endphp


{!! Theme::showScripts(false) !!}


@stack('scripts')
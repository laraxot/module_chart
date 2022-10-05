<head>
    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    {!! Theme::metatags() !!}
    @php
        //Theme::add('pub_theme::dist/css/app.css', 1);
        //Theme::add('theme::css/cookie-consent.css');
    @endphp
    <livewire:styles />
    {!! Theme::showStyles(false) !!}
    @stack('styles')
</head>

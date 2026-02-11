<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title id="seo_title">
    @if (isset($title))
        {{ $title }}
    @else
        {{ config('app.name') }}
    @endif
</title>
<meta id="seo_desc" name="description"
    content="@if (isset($desc) && $desc !== '') {{ $desc }} @else {{ __('description.default') }} @endif">
<meta property="og:title"
    content="@if (isset($title)) {{ $title }} @else {{ config('app.name') }} @endif">
<meta id="seo_fb" property="og:description"
    content="@if (isset($desc) && $desc !== '') {{ $desc }} @else {{ __('description.default') }} @endif">
<link rel="canonical" href="{{ url()->current() }}">
<link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-185115352-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-185115352-1');
</script>

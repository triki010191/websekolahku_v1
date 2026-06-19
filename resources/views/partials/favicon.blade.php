@php $faviconVer = @filemtime(public_path('favicon.ico')) ?: '1'; @endphp
<link rel="icon" href="{{ asset('favicon-light.png') }}?v={{ $faviconVer }}" type="image/png" sizes="32x32" media="(prefers-color-scheme: light)">
<link rel="icon" href="{{ asset('favicon-dark.png') }}?v={{ $faviconVer }}" type="image/png" sizes="32x32" media="(prefers-color-scheme: dark)">
<link rel="icon" href="{{ asset('favicon.ico') }}?v={{ $faviconVer }}" sizes="any">
<link rel="icon" href="{{ asset('favicon-32x32.png') }}?v={{ $faviconVer }}" type="image/png" sizes="32x32">
<link rel="icon" href="{{ asset('favicon-16x16.png') }}?v={{ $faviconVer }}" type="image/png" sizes="16x16">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v={{ $faviconVer }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}?v={{ $faviconVer }}">

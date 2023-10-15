<!DOCTYPE html>
<html class="{{ $darkMode ? 'dark' : '' }}{{ $colorScheme != 'default' ? ' ' . $colorScheme : '' }}"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ Vite::asset('resources/images/logo.png') }}" rel="shortcut icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Notre Dame of Cotabato.">
    <meta name="keywords" content="ndcotabato, notredamecotabato">
    <meta name="author" content="jrdemadara.dev">

    @yield('head')

    <!-- BEGIN: CSS Assets-->
    @vite('resources/css/app.css')
    @stack('styles')
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body>
    @yield('content')

    @vite('resources/js/app.js')

    <!-- BEGIN: Vendor JS Assets-->
    @stack('vendors')
    <!-- END: Vendor JS Assets-->

    <!-- BEGIN: Pages, layouts, components JS Assets-->
    @stack('scripts')
    <!-- END: Pages, layouts, components JS Assets-->
</body>

</html>

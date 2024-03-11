<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    @vite(['resources/css/app.css'])
</head>

<body>

    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <div class="page-main-header">
            <div class="main-header-right row m-0">
                <div class="main-header-left">
                    <div class="logo-wrapper"><a href="{{ route('home') }}"><img class="img-fluid" src="{{ Vite::asset('resources/images/logo/logo.png') }}" alt=""></a></div>
                    <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i></div>
                </div>

                <div class="left-menu-header col">
                    @include('components.search')
                </div>

                @include('components.nav-bar')
            </div>
        </div>

        <div class="page-body-wrapper horizontal-menu">
            <header class="main-nav">
                @include('components.side-bar')

                <nav>
                    <div class="main-navbar">
                        <div id="mainnav">
                            @include('components.main-nav')
                        </div>
                    </div>
                </nav>
            </header>

            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-6">
                                @yield('page-title')
                            </div>
                            <div class="col-sm-6 text-end">
                                @yield('page-options')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            @include('components.footer')
        </div>
    </div>

    @vite(['resources/js/app.js'])

</body>

</html>

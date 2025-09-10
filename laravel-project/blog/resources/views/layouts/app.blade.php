<html>
<head>
    <title>@yield('title')</title>
</head>
<body>
    {{-- Subview include --}}
    @include('partials.navbar')

    <div class="content">
        @yield('content')
    </div>

    @include('partials.footer')
</body>
</html>

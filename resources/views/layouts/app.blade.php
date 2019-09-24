<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials.head')
<body>
    @include('partials.topnav')
    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>

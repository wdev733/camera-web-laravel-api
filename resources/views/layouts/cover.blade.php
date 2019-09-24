<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('partials.head')

<body class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">

    @yield('content')

</body>

</html>

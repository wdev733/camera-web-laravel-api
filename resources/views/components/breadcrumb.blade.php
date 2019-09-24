<ol class="breadcrumb mx-4 my-2">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teams.index') }}">Members</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $slot }}</li>
</ol>

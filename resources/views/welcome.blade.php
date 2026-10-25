<x-layout title="Homepage">

    <div class="card">
        <div class="card-body">
            @if ($username)
                <h1>Welcome, {{ $username }}!</h1>
            @else
                <h1>Welcome!</h1>
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            @endif
        </div>
    </div>

</x-layout>
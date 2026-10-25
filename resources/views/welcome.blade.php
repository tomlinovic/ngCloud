<x-layout title="Homepage">

    <div class="card">
        <div class="card-body">
            @auth
                <h1>Welcome, {{ ucfirst(auth()->user()->username) }}!</h1>
            @else
                <h1>Welcome!</h1>
            @endauth
        </div>
    </div>

</x-layout>
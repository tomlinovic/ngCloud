<x-layout>
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-sm mt-5">
                <div class="card-body p-4">
                    <h1 class="h4 text-center mb-4">Login</h1>

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Username --}}
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                class="form-control @error('username') is-invalid @enderror"
                                required
                                autofocus
                                autocomplete="username"
                            >
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                                autocomplete="current-password"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember me --}}
                        <div class="form-check mb-4">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                value="1"
                                class="form-check-input"
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            <label for="remember" class="form-check-label">Remember me</label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary w-100">
                            Sign in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
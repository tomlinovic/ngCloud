<x-layout title="My Profile">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h4 mb-4">My Profile</h2>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->username }}" disabled readonly>
                            <div class="form-text">Username can not be changed.</div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">First Name</label>
                            <input type="text" id="name" name="name" 
                                   value="{{ old('name', auth()->user()->name) }}" 
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="surname" class="form-label">Last Name</label>
                            <input type="text" id="surname" name="surname" 
                                   value="{{ old('surname', auth()->user()->surname) }}" 
                                   class="form-control @error('surname') is-invalid @enderror" required>
                            @error('surname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="job" class="form-label">Job</label>
                            <input type="text" id="job" name="job" 
                                   value="{{ old('job', auth()->user()->job) }}" 
                                   class="form-control @error('job') is-invalid @enderror">
                            @error('job')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-layout>
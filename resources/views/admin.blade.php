<x-layout title="Admin Panel">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Admin Panel</h2>
            <div class="text-muted">Manage users and view storage</div>
        </div>
        <span class="badge bg-danger fs-6">Super User</span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small mb-2">Total Users</h6>
                    <h3 class="mb-0">{{ \App\Models\User::where('is_super_user', false)->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small mb-2">Total Files</h6>
                    <h3 class="mb-0">{{ \App\Models\File::count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small mb-2">Storage Used</h6>
                    <h3 class="mb-0">
                        {{ number_format(\App\Models\File::sum('size') / 1024 / 1024, 2) }} MB
                    </h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista običnih korisnika i njihov prostor --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">User Storage Details</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Job</th>
                            <th>Files Uploaded</th>
                            <th>Storage Used</th>
                            <th>Storage Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Dohvaćamo samo korisnike koji nisu super_user --}}
                        @foreach (\App\Models\User::where('is_super_user', false)->with('files')->get() as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="fw-semibold">{{ $user->username }}</td>
                                <td>{{ $user->name }} {{ $user->surname }}</td>
                                <td>{{ $user->job ?? '—' }}</td>
                                <td>{{ $user->files->count() }}</td>
                                <td>
                                    {{ number_format($user->storageUsed() / 1024 / 1024, 2) }} MB
                                </td>
                                <td>
                                    <span class="text-success fw-bold">
                                        {{ number_format($user->storageRemaining() / 1024 / 1024, 2) }} MB
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
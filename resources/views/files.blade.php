<x-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Your files</h2>
            <div class="text-muted">Upload and download your files</div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
            + Upload file
        </button>
    </div>

    {{-- Flash poruke --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistika kvote --}}
    <div class="card mb-4">
        <div class="card-body">
            @php
                $percent = $quota > 0 ? min(100, round($used / $quota * 100, 2)) : 0;
            @endphp
            <div class="d-flex justify-content-between mb-2">
                <strong>Storage</strong>
                <span class="text-muted">
                    {{ number_format($used / 1024 / 1024, 2) }} MB /
                    {{ number_format($quota / 1024 / 1024 / 1024, 2) }} GB
                </span>
            </div>
            <div class="progress" style="height: 20px;">
                <div class="progress-bar {{ $percent > 90 ? 'bg-danger' : ($percent > 70 ? 'bg-warning' : 'bg-success') }}"
                     role="progressbar"
                     style="width: {{ $percent }}%">
                    {{ $percent }}%
                </div>
            </div>
            <div class="small text-muted mt-2">
                Remaining: {{ number_format($remaining / 1024 / 1024, 2) }} MB
            </div>
        </div>
    </div>

    {{-- Lista fileova --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">My Files ({{ $files->total() }})</h5>

            @if ($files->isEmpty())
                <p class="text-muted mb-0">Još nemaš uploadanih fileova.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Uploaded</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($files as $file)
                                <tr>
                                    <td>
                                        <div class="text-truncate" style="max-width: 300px;">
                                            {{ $file->original_name }}
                                        </div>
                                        <small class="text-muted">{{ $file->mime_type }}</small>
                                    </td>
                                    <td>{{ $file->human_size }}</td>
                                    <td>{{ $file->created_at->format('d.m.Y H:i') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('files.download', $file) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Download
                                        </a>
                                        <form method="POST"
                                              action="{{ route('files.destroy', $file) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Obrisati file?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $files->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Modal za upload --}}
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Upload file</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file" class="form-label">Odaberi file</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                            <div class="form-text">
                                Max 100 MB po fileu. Preostalo: {{ number_format($remaining / 1024 / 1024, 2) }} MB
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout>
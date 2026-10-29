<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->is_super_user) {
            $query = File::with('user')
                ->select(['id', 'user_id', 'original_name', 'mime_type', 'size', 'created_at'])
                ->orderByDesc('created_at');
        } else {
            $query = $user->files()
                ->select(['id', 'user_id', 'original_name', 'mime_type', 'size', 'created_at'])
                ->orderByDesc('created_at');
        }

        $files = $query->paginate(5);

        return view('files', [
            'files' => $files,
            'used' => $user->storageUsed(),
            'quota' => $user->storageQuota(),
            'remaining' => $user->storageRemaining(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:102400'], 
        ]);

        $user = auth()->user();
        $uploaded = $request->file('file');
        $size = $uploaded->getSize();

        if (! $user->hasSpaceFor($size)) {
            return back()->withErrors([
                'file' => 'You dont have enough storage space left. Storage space left: '
                    . $this->formatBytes($user->storageRemaining()),
            ]);
        }

        File::create([
            'user_id' => $user->id,
            'original_name' => $uploaded->getClientOriginalName(),
            'mime_type' => $uploaded->getMimeType(),
            'size' => $size,
            'content' => file_get_contents($uploaded->getRealPath()),
        ]);

        return back()->with('success', 'File successfully uploaded.');
    }

    public function download(File $file)
    {
        $this->authorizeOwner($file);

        return response($file->content)
            ->header('Content-Type', $file->mime_type ?? 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $file->original_name . '"')
            ->header('Content-Length', $file->size);
    }

    public function destroy(File $file)
    {
        $this->authorizeOwner($file);
        $file->delete();

        return back()->with('success', 'File deleted.');
    }

    private function authorizeOwner(File $file): void
    {
        $user = auth()->user();

        if ($user->is_super_user) {
            return;
        }

        if ($file->user_id !== $user->id) {
            abort(403, 'You dont have access to this file.');
        }
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
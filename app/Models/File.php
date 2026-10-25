<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_name',
        'mime_type',
        'size',
        'content',
    ];

    protected $hidden = [
        'content',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type ?? '', 'image/');
    }

    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }

    public function getIconAttribute(): array
    {
        $mime = $this->mime_type ?? '';
        $ext = strtolower(pathinfo($this->original_name, PATHINFO_EXTENSION));

        return match (true) {
            str_starts_with($mime, 'image/') => ['icon' => 'bi-file-earmark-image', 'color' => 'text-success'],

            $mime === 'application/pdf' => ['icon' => 'bi-file-earmark-pdf', 'color' => 'text-danger'],

            str_contains($mime, 'word') || in_array($ext, ['doc', 'docx']) =>
                ['icon' => 'bi-file-earmark-word', 'color' => 'text-primary'],

            str_contains($mime, 'excel') || str_contains($mime, 'spreadsheet') || in_array($ext, ['xls', 'xlsx', 'csv']) =>
                ['icon' => 'bi-file-earmark-excel', 'color' => 'text-success'],

            str_contains($mime, 'powerpoint') || str_contains($mime, 'presentation') || in_array($ext, ['ppt', 'pptx']) =>
                ['icon' => 'bi-file-earmark-ppt', 'color' => 'text-warning'],

            in_array($mime, ['application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed'])
                || in_array($ext, ['zip', 'rar', '7z', 'tar', 'gz']) =>
                ['icon' => 'bi-file-earmark-zip', 'color' => 'text-warning'],

            str_starts_with($mime, 'video/') => ['icon' => 'bi-file-earmark-play', 'color' => 'text-danger'],

            str_starts_with($mime, 'audio/') => ['icon' => 'bi-file-earmark-music', 'color' => 'text-info'],

            str_starts_with($mime, 'text/') || in_array($ext, ['txt', 'md', 'log']) =>
                ['icon' => 'bi-file-earmark-text', 'color' => 'text-secondary'],

            in_array($ext, ['php', 'js', 'ts', 'css', 'html', 'json', 'xml', 'py', 'java', 'c', 'cpp']) =>
                ['icon' => 'bi-file-earmark-code', 'color' => 'text-dark'],

            default => ['icon' => 'bi-file-earmark', 'color' => 'text-secondary'],
        };
    }
}
<?php

namespace App\Services;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class AttachmentService
{
    protected string $disk;
    protected string $directory;
    /**
     * Create a new class instance.
     */
    public function __construct(
        string $disk = 'local', string $directory = 'email-attachments'
    )
    {
       $this->disk = $disk;
        $this->directory = $directory;
    }
     /**
     * Store an uploaded file and return metadata for emailing.
     */
    public function store(UploadedFile $file): array
    {
        $filename = Str::uuid() . '_' . $file->getClientOriginalName();
        $path     = $file->storeAs($this->directory, $filename, $this->disk);

        return [
            'path'          => Storage::disk($this->disk)->path($path),
            'name'          => $file->getClientOriginalName(),
            'stored_path'   => $path,
        ];
    }

    /**
     * Store multiple uploaded files.
     */
    public function storeMany(array $files): array
    {
        return collect($files)
            ->map(fn(UploadedFile $file) => $this->store($file))
            ->toArray();
    }

    /**
     * Delete a stored attachment by its stored path.
     */
    public function delete(string $storedPath): bool
    {
        return Storage::disk($this->disk)->delete($storedPath);
    }

    /**
     * Delete multiple attachments after sending.
     */
    public function deleteMany(array $attachments): void
    {
        collect($attachments)->each(fn($a) => $this->delete($a['stored_path']));
    }
}

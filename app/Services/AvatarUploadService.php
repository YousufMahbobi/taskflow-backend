<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvatarUploadService
{
    /**
     * Upload avatar to public storage
     */
    public function upload(UploadedFile $file): string
    {
        return $file->store('avatars', 'public');
    }

    /**
     * Delete avatar from public storage
     */
    public function delete(string $avatarPath): void
    {
        if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
            Storage::disk('public')->delete($avatarPath);
        }
    }

    /**
     * Get full URL for frontend
     */
    public function url(string $avatarPath): string
    {
        return $avatarPath ? Storage::url($avatarPath) : '';
    }
}

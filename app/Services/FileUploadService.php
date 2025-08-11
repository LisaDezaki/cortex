<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FileUploadService
{
    /**
     * Upload a file to a temporary location.
     */
    public function uploadToTemp(UploadedFile $file): string
    {
		// sleep(3);
        return $file->store('tmp', 'public'); // Stores in `storage/app/public/tmp`
    }
	

    /**
     * Move a file from temp to permanent location with a semantic name.
     */
	public function moveToPermanent(?string $tempPath, ?string $directory, string $newName): ?string
    {
		if (!$tempPath) { return null; }
		
		$user = Auth::user();
		$userEmail = $user->email;
		$project = $user->projects->find($user->active_project);
		$projectName = str_replace(' ', '-', $project->name);
        $filename  = basename($tempPath);
		$extension = pathinfo($tempPath, PATHINFO_EXTENSION);
		
		if ($directory) {
			$permanentPath = "$userEmail/$projectName/$directory/$newName.$extension";
		} else {
			$permanentPath = "$userEmail/$projectName/$newName.$extension";
		}
        
        Storage::disk('public')->move($tempPath, $permanentPath);
        
        return $permanentPath;
    }
}
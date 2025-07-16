<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\FileUploadService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ImageController extends Controller
{
	protected $uploadService;

	public function __construct(FileUploadService $uploadService)
	{
		$this->uploadService = $uploadService;
	}

	/**
     * Upload an image to a temporary folder in the database and return the new temp path.
     */
	public function upload(Request $request, Project $project)
    {

		// Validate the incoming request for the image
        $request->validate([
			'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust mime types and max size as needed
        ]);

		//	Store the file in a temporary location
		$path = $this->uploadService->uploadToTemp($request->file('file'));

		/* Return the temporary file URL */
		return response()->json([
        	'filePath' => $path,
			'fileUrl'  => Storage::url($path)]
		);
    }

	// public function storeFile(Request $request, Project $project, bool $replace = false): string {

	// 	if ($replace) {
    //         $this->deleteImage($project);
    //     }

    //     $path = $request->file('file')->store('projects', 'public');
    //     // $project->update(['image' => "/storage/{$path}"]);
	// 	return $path;
	// }

	// public function deleteImage(Project $project): void {

	// 	// If the project has an image path stored...
	// 	if ($project->image) {
	// 		// Remove the /storage/ prefix to get the relative path on the disk
	// 		$imagePath = str_replace('/storage/', '', $project->image);
	// 		// Specify the disk and delete the file
	// 		Storage::disk('public')->delete($imagePath);
	// 	}

	// }
}
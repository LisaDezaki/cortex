<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
	protected $mediaService;

	public function __construct(MediaService $mediaService)
	{
		$this->mediaService = $mediaService;
	}

	public function uploadTemp(Request $request)
	{
		$request->validate([
			'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust mime types and max size as needed
        ]);
		$file = $request->file('file');
		$fileInfo = $this->mediaService->storeTempFile($file);
		$fileInfo['path'] = Storage::url($fileInfo['temp_path']);
		return response()->json([
			'success' => true,
			'file' => $fileInfo
		]);
	}

	/**
     * Upload an image to a temporary folder in the database and return the new temp path.
     */
	public function upload(Request $request, Project $project)
    {
		// Validate the incoming request for the image
        // $request->validate([
		// 	'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust mime types and max size as needed
        // ]);

		// return response()->json([
        // 	'validated' => true
		// ]);

		//	Store the file in a temporary location
		// $file = $this->mediaService->uploadToTemp($request->file('file'));

		/* Return the temporary file URL */
		// return response()->json([
        // 	'temp_path' => $file['path'],
		// 	'mime_type' => $file['mime_type'],
		// 	'size' => $file['size']
		// ]);
    }
}
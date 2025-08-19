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
			'files' => 'array',
			'files.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);
		$filesData = [];
		$files = $request->file('files');
		foreach ($files as $file) {
			$fileInfo = $this->mediaService->storeTempFile($file);
			$filesData[] = $fileInfo;
		}
		return response()->json([
			'success' => true,
			'files' => $filesData
		]);
	}
}
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

	public function moveToPermanent(Request $request)
	{

		$request->validate([
			'files' => 'string',
			'type' => 'required|in:project_banner,character_portrait'
        ]);

		$user = Auth::user();
		$userDir    = "user_"   .substr($user->id, 0, 8);
		$projectDir = "project_".substr($user->active_project, 0, 8);

		$destination = [
			"character_portrait" => "$userDir/$projectDir/characters"
		];

		$fileInfo = $this->mediaService->moveToPermanent($request['files'], $destination[$request['type']]);

		return response()->json([
			'data' => $fileInfo
		]);
	}
}
<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
	protected $mediaService;

	public function __construct(MediaService $mediaService)
	{
		$this->mediaService = $mediaService;
	}

	public function uploadTemp(Request $request)
	{
		//	Check if files are actually uploaded
		if (!$request->hasFile('files')) {
			return back()->withErrors([
				'error' => 'No files were uploaded.'
			]);
		}

		//	Check if files are valid
		foreach ($request->file('files') as $index => $file) {
			if (!$file->isValid()) {
				return back()->withErrors([
					'error' => $file->getErrorMessage()
				]);
			}
		}

		//	Validation
		$validator = Validator::make($request->all(), [
			'files' => 'array',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB max
        ], [
			'files.array' => 'Files must be provided as an array.',
            'files.*.image' => 'The uploaded image is not valid.',
            'files.*.mimes' => 'Only JPEG, PNG, JPG, and GIF files are allowed.',
            'files.*.max' => 'The file size must not exceed 2MB.',
        ]);
        if ($validator->fails()) {
			return back()->withErrors($validator->errors());
		}

		//	Store temporary files
		$filesData = [];
		$files = $request->file('files');
		try {
			foreach ($files as $file) {
				$fileInfo = $this->mediaService->storeTempFile($file);
				$filesData[] = $fileInfo;
			}
		} catch (\Exception $e) {
			return back()->withErrors($e);
		}

		Session::flash('success', $filesData);
		return Redirect::back();
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
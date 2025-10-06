<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Media;
use App\Models\Project;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
	protected $mediaService;

	public function __construct(MediaService $mediaService)
	{
		$this->mediaService = $mediaService;
	}

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('User/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }



    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->user()->fill($request->all());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

		if ($request->has('media') && $request['media'] !== null) {
			foreach ($request['media'] as $media) {
				$this->mediaService->attachMedia(Auth::user(), $media['type'], $media);
			}
			// unset($validatedData['media']);
		}

        $request->user()->update();

		Session::flash('success', "User updated successfully.");
        return Redirect::back();
    }



	/**
     * HANDLERS
	 * Helper functions to reduce code duplication
     */

	public function updateAvatar(Request $request)
	{
		// $user = Auth::user();

		// if ($request->has('media')) {
		// 	foreach ($request['media'] as $media) {
		// 		$this->mediaService->attachMedia($user, $media['type'], $media);
		// 	}
		// 	unset($validatedData['media']);
		// }
		// Session::flash('success', "Avatar updated successfully.");
        // return Redirect::back();

		// $request->validate([
		// 	'temp_path' => 'string|nullable',
		// ]);

		// $user = Auth::user();
		// $userFolder = "user_".substr($user->id, 0, 8);

		// return $this->mediaService->updateImage(
		// 	$user,
		// 	$user->avatar(),
		// 	$request->temp_path,
		// 	"$userFolder"
		// );

		// try {
		// 	if ($request->has('temp_path') && empty($request->temp_path)) {
		// 		Storage::delete($user->avatar->path); // Optionally delete the file from storage
		// 		$user->avatar->delete(); // Delete the Media record
		// 		return;
		// 	}

		// 	if (is_numeric($request->temp_path)) {
		// 		$media = Media::findOrFail($request->temp_path);
		// 		if ($media->mediable_type !== User::class || $media->mediable_id !== $user->id) { // Ensure this media actually belongs to this project
		// 			abort(403, 'This media does not belong to this user');
		// 		}
		// 		return;
		// 	}

		// 	// Case 3: New image uploaded (temporary path provided)
		// 	if ($request->temp_path) {

		// 		// First remove any existing banner
		// 		if ($user->avatar) {
		// 			Storage::delete($user->avatar->path); // Optionally delete the file from storage
		// 			$user->avatar->delete(); // Delete the Media record
		// 		}

		// 		// Store new file
		// 		$store = $this->mediaService->moveToPermanent(
		// 			$request->temp_path,
		// 			"$user->id"
		// 		);

		// 		// Create and associate new Media
		// 		$media = $user->avatar()->create([
		// 			'type' => 'user_avatar',
		// 			'path' => $store['newPath'],
		// 			'mediable_type' => User::class,
		// 			'mediable_id'   => $user->id,
		// 		]);

		// 		return response()->json([
		// 			'success' => true,
		// 			'requestHasTempPath' => $request->has('temp_path'),
		// 			'isEmptyRequest' => empty($request->temp_path),
		// 			'isNumeric' => is_numeric($request->temp_path),
		// 			'userAvatar' => $user->avatar,
		// 			'store' => $store,
		// 			'media' => $media,
		// 			'redirect' => route('user.edit'),
		// 			'flash' => [
		// 				'success' => 'Avatar updated successfully!'
		// 			]
		// 		]);
		// 	}

		// } catch (\Illuminate\Validation\ValidationException $e) {
		// 	return response()->json([
		// 		'errors' => $e->errors(),
		// 		'message' => 'Validation failed'
		// 	], 422);
		// } catch (\Exception $e) {
		// 	return response()->json([
		// 		'error' => $e->getMessage(),
		// 		'file' => $e->getFile(),
		// 		'line' => $e->getLine()
		// 	], 500);
		// }
		
	}

	public function settings(Request $request): Response
	{
		return Inertia::render('User/Settings');
	}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

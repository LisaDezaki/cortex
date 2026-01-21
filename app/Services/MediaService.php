<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Faction;
use App\Models\Location;
use App\Models\Media;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
	protected string $tempDisk   = 'public';
    protected string $tempFolder = 'tmp';
    protected string $permDisk   = 'public';

	/*
	 * StoreTempFile
	 * 
	 * Store a file temporarily in the temp disk and folder.
	 * Returns the path, url, and original name of the file.
	 */

	public function storeTempFile($file)
    {
        $fileName = $this->generateFileName($file);
        $path = $file->storeAs($this->tempFolder, $fileName, $this->tempDisk);
        
        return [
			'path' => $path,
            'url' => Storage::url($path),
            'name' => $file->getClientOriginalName(),
        ];
    }

	/*
	 * MoveToPermanent
	 * 
	 * Move a file from the temp disk and folder to a permanent location.
	 * Returns the new path and other info about the move.
	 */

	public function moveToPermanent(string|array|null $tempPath, string $destinationFolder)
    {
		if ($tempPath === null) { return; }

        $fileName = basename($tempPath);
        $newPath = $destinationFolder.'/'.$fileName;

		try {
			if (!$this->fileExists($tempPath)) {
				throw new \Exception("There was no file to move at $tempPath.");
				Session::flash('error', "There was no file to move at $tempPath.");
			}
			$moved = Storage::disk('public')->move($tempPath, $newPath);
			if (!$moved) {
				throw new \Exception("Failed to move file from $tempPath to $newPath.");
				Session::flash('error', "Failed to move file from $tempPath to $newPath.");
			}
			if (!$this->fileExists($newPath)) {
				throw new \Exception("The file didn't make it to $newPath for some reason.");
				Session::flash('error', "The file didn't make it to $newPath for some reason.");
			}

			return [
				'success' => true,
				'disk' => $this->permDisk,
				'filepath' => $newPath,
				'tempPath' => $tempPath,
				'destinationFolder' => $destinationFolder,
				'fileName' => $fileName,
				'newPath' => $newPath,
			];
		} catch (\Exception $e) {
			return [
				'success' => false,
				'exception' => $e,
				'message' => $e->getMessage()
			];
		}

    }

	/*
	 * attachMedia
	 * 
	 * Attach media to a model via a morphOne or morphMany relationship.
	 * Moves the file from temp to permanent storage and creates the Media record.
	 */

	public function attachMedia( Model $entity, string $type, mixed $filepath )
	{
		if ( Media::where('id', $filepath)->exists() ) { return; }

		//	If $entity === User,
		//	$userDir = "user_..."

		//	If $entity === Project,
		//	$projectDir = "project_..."

		//	If $entity === Other
		//	$entityName

		$user = Auth::user();
		$userDir    = "user_"   .substr($user->id, 24, 12);
		$projectDir = "project_".substr($user->active_project, 24, 12);

		$relationship = $entity->$type();
		$entityName   = strtolower(class_basename($entity->getMorphClass()));
		$entityDir    = $entityName."_".substr($entity->id, 24, 12);

		if ($entityName === "user") {
			$newpath = "$userDir";
		} else if ($entityName === "project") {
			$newpath = "$userDir/$projectDir";
		} else if ($entityName) {
			$newpath = "$userDir/$projectDir/$entityName/$entityDir";
		}

		if ($relationship) {
			$this->deleteImage($relationship);
		}

		if (gettype($filepath) == 'string') {
			$this->updateImage(
				$entity,
				$relationship,
				$filepath,
				$newpath
			);
		} else if (gettype($filepath) == 'array') {
			$this->updateMany(
				$entity,
				$relationship,
				$filepath,
				$newpath
			);
		}
	}

	/*
	 * updateImage
	 * 
	 * Update a single image for a model via a morphOne or morphMany relationship.
	 * Moves the file from temp to permanent storage and creates the Media record.
	 */

	public function updateImage(
		Model $entity,
		MorphOne|MorphMany $relationship,
		string $temp_path,
		string $folder,
	) {

		//	If there is no relationship or if the value is already a media ID that matches this type, do nothing.
		if (!$relationship || Media::where('id', $temp_path)->exists() ) {
			return;
		}

		$this->deleteImage($relationship);

		// Store new file
		$store = $this->moveToPermanent(
			$temp_path,
			$folder
		);

		// Create and associate new Media
		if (isset($store['newPath'])) {
			return $relationship->updateOrCreate([
				'mediable_id' => $entity->id,
				'mediable_type' => $entity->getMorphClass(),
				'path' => $store['newPath'],
				'type' => $this->getMediaTypeFromRelationship($relationship),
			]);
		}
	}

	/*
	 * updateMany
	 * 
	 * Update multiple images for a model via a morphOne or morphMany relationship.
	 * Moves the files from temp to permanent storage and creates the Media records.
	 */

	public function updateMany(
		Model $entity,
		MorphOne|MorphMany $relationship,
		array $paths,
		string $folder,
	) {
		
		//	If there is no relationship or if the value is already a media ID that matches this type, do nothing.
		if (!$relationship) { return; }
		
		$response = [];
	
		foreach ($paths as $path) {
			
			//	If there is no relationship or if the value is already a media ID that matches this type, do nothing.
			if (Media::where('id', $path)->exists()) {
				continue;
			}

			// Store new file
			$store = $this->moveToPermanent(
				$path, $folder
			);
			
			// Create and associate new Media
			if (isset($store['newPath'])) {
				$response[] = $relationship->create([
					'mediable_id' => $entity->id,
					'mediable_type' => $entity->getMorphClass(),
					'path' => $store['newPath'],
					'type' => $this->getMediaTypeFromRelationship($relationship)
				]);
			}
		}

		return $response;

	}

	/*
	 * deleteImage
	 * 
	 * Delete an image associated with a model via a morphOne or morphMany relationship.
	 * Deletes the file from storage and the Media record.
	 */

	public function deleteImage(MorphOne|MorphMany $relationship)
	{
		if ($media = $relationship->first()) {
            return Storage::delete($media->path) && $media->delete();
        }
		return false;
	}

    public function deleteTempFile($tempPath)
    {
        if (Storage::disk($this->tempDisk)->exists($tempPath)) {
            return Storage::disk($this->tempDisk)->delete($tempPath);
        }
        return false;
    }

	public function fileExists($path, $disk = 'public')
	{
		if (!$path) { return false; }
		$disk = $disk ?? $this->tempDisk;
		return Storage::disk($disk)->exists($path);
	}

    protected function generateFileName($file)
    {
        return Str::random(20).'.'.$file->extension();
    }

	protected function getMediaTypeFromRelationship(MorphOne|MorphMany $relationship): string
	{
		$wheres = $relationship->getQuery()->getQuery()->wheres;
		
		foreach ($wheres as $where) {
			if ($where['column'] === 'type') {
				return $where['value'];
			}
		}
		
		throw new \RuntimeException('Media type not found in relationship constraints');
	}

    public function getTempUrl($path)
    {
        return Storage::url($path);
    }
}
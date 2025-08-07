<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Faction;
use App\Models\Location;
use App\Models\Media;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
	protected string $tempDisk = 'public';
    protected string $tempFolder = 'tmp';
    protected string $permDisk = 'public';













	public function storeTempFile($file)
    {
        $fileName = $this->generateFileName($file);
        $path = $file->storeAs($this->tempFolder, $fileName, $this->tempDisk);
        
        return [
            'temp_path' => $path,
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'url' => Storage::url($path)
        ];
    }







	public function moveToPermanent(string|null $tempPath, string $destinationFolder)
    {
		if ($tempPath === null) { return; }
        $fileName = basename($tempPath);		
        $newPath = $destinationFolder.'/'.$fileName;
		// Storage::disk('public')->move($tempPath, $newPath);

		try {
			if (!$this->fileExists($tempPath)) {
				throw new \Exception("There was no file to move at $tempPath.");
			}
			$moved = Storage::disk('public')->move($tempPath, $newPath);
			if (!$moved) {
				throw new \Exception("Failed to move file from $tempPath to $newPath.");
			}
			if (!$this->fileExists($newPath)) {
				throw new \Exception("The file didn't make it to $newPath for some reason.");
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
    







	public function updateImage(
		Model $entity,
		MorphOne $relationship,
		mixed $temp_path,
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

	public function deleteImage(MorphOne $relationship)
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

	protected function getMediaTypeFromRelationship(MorphOne $relationship): string
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
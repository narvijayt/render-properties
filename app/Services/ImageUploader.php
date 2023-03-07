<?php
namespace App\Services;

use Image;
use Ramsey\Uuid\Uuid;
use Storage;
use SplFileInfo;

class ImageUploader
{
	/**
	 * @var \Intervention\Image\Image
	 */
	protected $file;

	/**
	 * @var \Illuminate\Contracts\Filesystem\Filesystem
	 */
	protected $disk;

	/**
	 * @var string
	 */
	protected $filename;

	/**
	 * @var string
	 */
	protected $extension;
	/**
	 * @var string
	 */
	protected $path;

	/**
	 * ImageUploader constructor.
	 */
	public function __construct()
	{
		$this->extension = config('upload.default_extension');
	}

	/**
	 * @param string $fileName
	 * @return $this
	 * @throws \Exception
	 */
	public function openImage(string $fileName)
	{
		$path = "{$this->path}{$fileName}";
		$this->filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);

		if (!$this->disk->exists($path)) {
			throw new \Exception('File not found at path: '.$path);
		}

		$file = $this->disk->get($path);

		$this->file = Image::make($file);
		$this->file->fit(1200, null, null, 'top');
		return $this;
	}

	/**
	 * Set the image to be manipulated
	 *
	 * @param SplFileInfo $file
	 *
	 * @return $this
	 */
	public function setImage(SplFileInfo $file)
	{
		$this->file = Image::make($file);
		$this->file->fit(1200, null, null, 'top');
		$this->filename = Uuid::uuid4()->toString();

		return $this;
	}

	/**
	 * @param string $disk
	 * @return $this
	 */
	public function setStorageDisk(string $disk)
	{
		$this->disk = Storage::disk($disk);

		return $this;
	}

	/**
	 * @param string $path
	 * @return $this
	 */
	public function setStoragePath(string $path)
	{
		$this->path = $path;

		return $this;
	}

	/**
	 * @param string $extension
	 * @return $this
	 */
	public function setExtension(string $extension)
	{
		$this->extension = $extension;

		return $this;
	}


	/**
	 * @return $this
	 */
	public function generateThumbnails()
	{
		foreach(config('upload.thumbnail_sizes') as $key => $dimensions) {
			$this->file->backup();
			$this->file->fit($dimensions['width'], $dimensions['width'], null, 'top');
			$this->disk->put(
				$this->getPath($key),
				(string) $this->file->encode($this->extension, 80)
			);
			$this->file->reset();
		}

		return $this;
	}

	/**
	 * @return $this
	 */
	public function putOriginal()
	{
		$this->disk->put(
			$this->getPath(),
			(string) $this->file->encode($this->extension, 80)
		);

		return $this;
	}

	/**
	 * @param string|null $postfix
	 * @return string
	 */
	protected function getPath(string $postfix = null)
	{
		$postfix = $postfix ? '-'.$postfix : '';
		$path = "{$this->path}{$this->filename}{$postfix}.{$this->extension}";

		return $path;
	}

	/**
	 * @return string
	 */
	public function getFilename()
	{
		return $this->filename;
	}

	/**
	 * @return mixed|string
	 */
	public function getExtension()
	{
		return $this->extension;
	}

	public function destroy()
	{
		$this->file->destroy();
	}
}

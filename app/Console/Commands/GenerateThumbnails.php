<?php

namespace App\Console\Commands;

use App\Services\ImageUploader;
use App\UserAvatar;
use Illuminate\Console\Command;

class GenerateThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thumbnails:profile-photo-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate thumbnails for all user profile pictures';
	/**
	 * @var ImageUploader
	 */
	private $uploader;

	/**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ImageUploader $uploader)
    {

        parent::__construct();

		ini_set('max_execution_time', 3600);
		ini_set('memory_limit', '512M');

		$this->uploader = $uploader;
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $avatars = UserAvatar::all();
		$progress = $this->output->createProgressBar($avatars->count());
		$avatars->each(function(UserAvatar $image) use ($progress) {
        	try {
				$this->uploader->setStorageDisk(config('upload.user_avatar_disk'))
					->setStorageDisk(config('upload.user_avatar_disk'))
					->setExtension(config('upload.default_extension'))
					->setStoragePath(config('upload.paths.profile-pictures'))
					->openImage($image->name)
					->generateThumbnails()
					->destroy();
			} catch(\Exception $e) {
//        		$this->info($e);
			}
			$progress->advance();
		});
		$this->info('Done processing '.$avatars->count().' images');
		$progress->finish();
    }
}

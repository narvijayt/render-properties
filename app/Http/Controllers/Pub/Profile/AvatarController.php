<?php

namespace App\Http\Controllers\Pub\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\Profile\ProfileAvatarUploadRequest;
use App\Services\ImageUploader;
use App\UserAvatar;
use DB;
use Illuminate\Config\Repository as Config;

class AvatarController extends Controller
{
	public function store(ProfileAvatarUploadRequest $request, Config $config, ImageUploader $uploader)
	{
	//	$this->authorize('create', UserAvatar::class);

//		$file = $request->file('avatar');
        $image = $request->get('avatar');
        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);

        $image_name= md5(date('Y-m-d H:i:s',time())).'.png';
        $path = public_path('profile_pictures/'.$image_name);
	//	DB::beginTransaction();
        file_put_contents($path, $image);
        $avatar = new UserAvatar;

        $avatar->fill([
            'user_id' => $this->auth->user()->user_id,
            'name' => $image_name,
            'original_name' => $image_name,
        ]);

        if ($avatar->save() === true) {
            $this->auth->user()->setAvatar($avatar);
            return "success";
        } else {
            return "failure";
        }
		/*try {
			$uploader->setStorageDisk(config('upload.user_avatar_disk'))
				->setStorageDisk(config('upload.user_avatar_disk'))
				->setExtension(config('upload.default_extension'))
				->setStoragePath(config('upload.paths.profile-pictures'))
				->setImage($file)
				->putOriginal()
				->generateThumbnails();


			die();

			$avatar = new UserAvatar;
			$avatar->fill([
				'user_id' => $this->auth->user()->user_id,
				'name' => $uploader->getFilename() . '.' . $uploader->getExtension(),
				'original_name' => $file->getClientOriginalName(),
			]);

			if ($avatar->save() === true) {
				$this->auth->user()->setAvatar($avatar);
				flash('Avatar updated successfully')->success();
			} else {
				flash('Unable to update avatar')->warning();
			}

			//DB::commit();
		} catch (\Exception $e) {
			dd($e);
			//DB::rollBack();
		}

		return redirect()->back();*/
	}
}

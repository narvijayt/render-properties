<?php

namespace App\Http\Controllers;
use Storage;
use App\UserAvatar;
use Illuminate\Http\Request;

class AzureImages extends Controller
{
    
    public function fetchAzureServerProfilePicture(Request $request)
    {
        $azureurl = 'https://' . config('filesystems.disks.azure.name'). '.blob.core.windows.net/' . config('filesystems.disks.azure.container') . '/profile-pictures/';
         $dbAvtarImages = (new UserAvatar)->all();
        foreach($dbAvtarImages as $index => $avatarName)
        {
            
            $imgName = $avatarName->name;
            $ext = pathinfo($imgName, PATHINFO_EXTENSION);
            $basename = basename($imgName,".".$ext);
            $dir = public_path('profile_pictures/');
            $readDir = array_slice(scandir($dir),2);
            foreach($readDir as $dirFile)
            {
                if($imgName == $dirFile)
                {
                    $serverPath = public_path('azure_thumbnail/'.$imgName);
                    $profile_image = file_get_contents($dir.$imgName); 
                    file_put_contents($serverPath, $profile_image);
                }
            }
            
            
            
        }
    }
   
    public function fetchsmallAzureProfilePictures(Request $request)
    {
        $azureurl = 'https://' . config('filesystems.disks.azure.name'). '.blob.core.windows.net/' . config('filesystems.disks.azure.container') . '/profile-pictures/';
        $dbAvtarImages = (new UserAvatar)->all();
        foreach($dbAvtarImages as $index => $avatarName)
        {
            $imgName = $avatarName->name;
            $ext = pathinfo($imgName, PATHINFO_EXTENSION);
            $basename = basename($imgName,".".$ext);
            $smallImgName = $basename.'-small.'.config('upload.default_extension');
            $filepath = $azureurl.$smallImgName;
            $path = public_path('azure_small/'.$smallImgName);
            if (file_exists($path))
            {
                echo "The file $path exists";
            } else{
                try{
                   $profile_image = file_get_contents($filepath);
                  file_put_contents($path, $profile_image);
                  sleep(1);
                } catch (\Exception $e)
                {
                    
                }
            }
        }
    }
   
    public function fetchmediumAzureProfilePictures(Request $request)
    {
        $azureurl = 'https://' . config('filesystems.disks.azure.name'). '.blob.core.windows.net/' . config('filesystems.disks.azure.container') . '/profile-pictures/';
        $dbAvtarImages = (new UserAvatar)->all();
        foreach($dbAvtarImages as $index => $avatarName)
        {
            $imgName = $avatarName->name;
            $ext = pathinfo($imgName, PATHINFO_EXTENSION);
            $basename = basename($imgName,".".$ext);
            $mediumimg = $basename.'-medium.'.config('upload.default_extension');
            $filepath = $azureurl.$mediumimg;
            $path = public_path('azure_medium/'.$mediumimg);
            if (file_exists($path)) 
            {
              echo "The file $path exists";
            } else{
                try{
                    $profile_image = file_get_contents($filepath);
                     file_put_contents($path, $profile_image);
                     sleep(1);
                } catch (\Exception $e) 
                {
                     echo "errored for User ID ". $avatarName->user_id . ") Image name =>  $imgName with path : $filepath  <br>";
                }
            }
        }
    }
   
    public function fetchlargeAzureProfilePictures(Request $request)
    {
        $azureurl = 'https://' . config('filesystems.disks.azure.name'). '.blob.core.windows.net/' . config('filesystems.disks.azure.container') . '/profile-pictures/';
        $dbAvtarImages = (new UserAvatar)->all();
            foreach($dbAvtarImages as $index => $avatarName)
            {
                $imgName = $avatarName->name;
                $ext = pathinfo($imgName, PATHINFO_EXTENSION);
                $basename = basename($imgName,".".$ext);
                $largeimg = $basename.'-large.'.config('upload.default_extension');
                $filepath = $azureurl.$largeimg;
                $path = public_path('azure_large/'.$largeimg);
                if (file_exists($path)) 
                {
                     echo "The file $path exists";
                } else
                {
                    try{
                         $profile_image = file_get_contents($filepath);
                         file_put_contents($path, $profile_image);
                         sleep(1);
                    }
                    catch (\Exception $e) 
                    {
                          echo "errored for User ID ". $avatarName->user_id . ") Image name =>  $imgName with path : $filepath  <br>";  
                    }
                }
            }
    }
   
   
    public function fetchxlargeAzureProfilePictures(Request $request)
    {
        $azureurl = 'https://' . config('filesystems.disks.azure.name'). '.blob.core.windows.net/' . config('filesystems.disks.azure.container') . '/profile-pictures/';
        $dbAvtarImages = (new UserAvatar)->all();
        foreach($dbAvtarImages as $index => $avatarName)
        {
            $imgName = $avatarName->name;
            $ext = pathinfo($imgName, PATHINFO_EXTENSION);
            $basename = basename($imgName,".".$ext);
            $xsmallimg = $basename.'-x-small.'.config('upload.default_extension');
            $filepath = $azureurl.$xsmallimg;
            $path = public_path('azure_xsmall/'.$xsmallimg);
            if (file_exists($path)) 
            {
                echo "The file $path exists";
            } else{
                try{
                    $profile_image = file_get_contents($filepath);
                    file_put_contents($path, $profile_image);
                    sleep(1);
                }
                catch (\Exception $e) 
                {
                    echo "errored for User ID ". $avatarName->user_id . ") Image name =>  $imgName with path : $filepath  <br>";
                }
            }
        }
    }
    
    
    public function fetchLargeWithoutSize(Request $request)
    {
        $azureurl = 'https://' . config('filesystems.disks.azure.name'). '.blob.core.windows.net/' . config('filesystems.disks.azure.container') . '/profile-pictures/';
        $dbAvtarImages = (new UserAvatar)->all();
            foreach($dbAvtarImages as $index => $avatarName)
            {
                $imgName = $avatarName->name;
                $ext = pathinfo($imgName, PATHINFO_EXTENSION);
                $basename = basename($imgName,".".$ext);
                $largeimg = $basename.'-large.'.config('upload.default_extension');
                $filepath = $azureurl.$largeimg;
                $path = public_path('azure_thumbnail/'.$largeimg);
                if (file_exists($path)) 
                {
                     echo "The file $path exists";
                } else
                {
                    try{
                         $profile_image = file_get_contents($filepath);
                         file_put_contents($path, $profile_image);
                         sleep(1);
                    }
                    catch (\Exception $e) 
                    {
                          echo "errored for User ID ". $avatarName->user_id . ") Image name =>  $imgName with path : $filepath  <br>";  
                    }
                }
            }
    }
   
   
   
   
    public function fetchLargeIntoNormalImage(Request $request)
    {
         $azureurl = 'https://' . config('filesystems.disks.azure.name'). '.blob.core.windows.net/' . config('filesystems.disks.azure.container') . '/profile-pictures/';
        $dbAvtarImages = (new UserAvatar)->all();
        foreach($dbAvtarImages as $index => $avatarName)
        {
            $imgName = $avatarName->name;
            $ext = pathinfo($imgName, PATHINFO_EXTENSION);
            $basename = basename($imgName,".".$ext);
            $dir = public_path('azure_thumbnail/');
            $filesname = array_slice(scandir($dir),2);
           foreach($filesname as $file)
            {
                $filename = substr($file, 0, strrpos($file, '-large')).'.png';
                $fileext =  substr($file, 0, strrpos($file, '-large'));
                 if($basename == $fileext){
                 rename($dir.$file, $dir.$fileext.'.'.$ext);
                }
            }
        }
    }
   
}

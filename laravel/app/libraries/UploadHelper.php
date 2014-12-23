<?php

class UploadHelper
{

    public function uploadsPath()
    {
        return  public_path() . DIRECTORY_SEPARATOR . 'uploads';
    }

    public function uploadProfilePicture($userId, $fileInputName, $width = 200, $height = 200)
    {
        $user = User::find($userId);

        if (Input::hasFile($fileInputName) AND $user) {
            $extension = Input::file($fileInputName)->getClientOriginalExtension();
            $fileName = Str::random();
            $fullFileName = $fileName . '.' . $extension;

            //TODO: THIS PART WILL USE S3, NO NEED TO STORE IMAGE

            $destinationPath = $this->uploadsPath() . '/users/' . $userId;

            ## Let's make sure that the upload path for users exist, if not then create it
            if (!is_dir($destinationPath)){
                mkdir($destinationPath);
            }

            ## Do actual moving of the file into destination
            Input::file($fileInputName)->move($destinationPath, $fullFileName);
            ## Resize the image according to desired with constraining aspect ratio
            Image::make($destinationPath . DIRECTORY_SEPARATOR . $fullFileName)->resize($width, $height, function ($constraint){
                $constraint->aspectRatio();
            })->save();

            return true;
        }
        return false;
    }

    public function prepareUploadDirectories()
    {
        # Prepare Public Uploads Directory
        $uploadsPath = $this->uploadsPath();
        if (!is_dir($uploadsPath)){
            mkdir($uploadsPath);
        }

        ## Prepare Users Upload Directory
        $usersUploadPath = $uploadsPath . '/users';
        if (!is_dir($usersUploadPath)){
            mkdir($usersUploadPath);
        }
    }
}
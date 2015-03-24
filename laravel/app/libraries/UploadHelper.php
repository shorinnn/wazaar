<?php

class UploadHelper
{

    public function uploadsPath()
    {
        return public_path() . DIRECTORY_SEPARATOR . 'uploads';
    }

    /**
     * @param $file - The physical path to the file
     * @param string $prefixSegment - The segment that comes before the actual filename e.g. 'avatar' - avatar/3909239023902390.gif
     * @param null $bucket - S3 Bucket name
     * @return string - S3 URL to the image
     */
    public function moveToAWS($file, $prefixSegment = '', $bucket = null)
    {
        $key = Str::random();

        $mime      = mimetype($file);
        $extension = mime_to_extension($mime);
        $fileContents      = file_get_contents($file);


        $s3 = AWS::get('s3');

        if (is_null($bucket)) {
            $bucket = getenv('AWS_BUCKET');
        }

        $result = $s3->putObject(array(
            'ACL'         =>  'public-read',
            'Bucket'      =>  $bucket,
            'ContentType' =>  $mime,
            'Key'         =>  $prefixSegment . '/' . $key . $extension,
            'Body'        =>  $fileContents
        ));

        //remove file
        unlink($file);

        return $result;
    }

    /**
     * Upload an image type file with few parameters as options
     * @param $fileInputName - The FILE Input name
     * @param int $width
     * @param int $height
     * @param bool $aspectRatio - Set to True if you want aspect ratio to be maintained when resizing, $width must be greater than 0
     * @return null|string - Physical path to the file
     */
    public function uploadImage($fileInputName, $width = 200, $height = 200, $aspectRatio = true)
    {
        $imagePath = $this->doUpload($fileInputName);

        if ($width !== 0 AND $imagePath) {
            ## Resize the image according to desired with constraining aspect ratio
            Image::make($imagePath)->resize($width, $height,
                function ($constraint) use ($aspectRatio) {
                    if ($aspectRatio) {
                        $constraint->aspectRatio();
                    }
                })->save();
        }

        return $imagePath;
    }

    /**
     * Upload any media type (video, image, file, etc.)
     * @param $fileInputName
     * @return string
     */

    public function uploadMedia($fileInputName)
    {
        return $this->doUpload($fileInputName);
    }

    private function doUpload($fileInputName)
    {
        $this->prepareUploadDirectories();

        if (Input::hasFile($fileInputName)) {
            $extension = Input::file($fileInputName)->getClientOriginalExtension();
            $baseName  = Str::random();
            $fileName  = $baseName . '.' . $extension;

            $destinationPath = $this->uploadsPath();

            ## Do actual moving of the file into destination
            Input::file($fileInputName)->move($destinationPath, $fileName);

            $mediaPath = $destinationPath . DIRECTORY_SEPARATOR . $fileName;

            return $mediaPath;
        }

        return null;
    }

    public function prepareUploadDirectories()
    {
        # Prepare Public Uploads Directory
        $uploadsPath = $this->uploadsPath();
        if (!is_dir($uploadsPath)) {
            mkdir($uploadsPath);
        }
    }
}
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

        $file      = file_get_contents($file);
        $mime      = mimetype($file);
        $extension = mime_to_extension($mime);

        $s3 = AWS::get('s3');

        if (is_null($bucket)) {
            $bucket = getenv('AWS_BUCKET');
        }

        $result = $s3->putObject(array(
            'ACL'         =>  'public-read',
            'Bucket'      =>  $bucket,
            'ContentType' =>  $mime,
            'Key'         =>  $prefixSegment . '/' . $key . $extension,
            'Body'        =>  $file
        ));

        return $result->get('ObjectURL');
    }

    /**
     * @param $fileInputName - The FILE Input name
     * @param int $width
     * @param int $height
     * @param bool $aspectRatio - Set to True if you want aspect ratio to be maintained when resizing, $width must be greater than 0
     * @return null|string - Physical path to the file
     */
    public function uploadImage($fileInputName, $width = 200, $height = 200, $aspectRatio = true)
    {
        $this->prepareUploadDirectories();

        if (Input::hasFile($fileInputName)) {
            $extension    = Input::file($fileInputName)->getClientOriginalExtension();
            $baseName     = Str::random();
            $fileName = $baseName . '.' . $extension;

            $destinationPath = $this->uploadsPath();

            ## Do actual moving of the file into destination
            Input::file($fileInputName)->move($destinationPath, $fileName);

            $imagePath = $destinationPath . DIRECTORY_SEPARATOR . $fileName;

            if ($width !== 0) {
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
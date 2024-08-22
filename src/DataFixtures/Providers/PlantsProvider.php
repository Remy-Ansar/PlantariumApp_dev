<?php

namespace App\DataFixtures\Providers;

use Symfony\Component\HttpFoundation\File\File;
Use Symfony\Component\HttpFoundation\File\UploadedFile;

class PlantsProvider
{
    public function uploadImage(): UploadedFile
    {
        $files =  glob(\dirname(__DIR__) . '/images/Plants/*.*');

        if (empty($files)) {
            throw new \RuntimeException('No images found in the specified directory.');
        }

        $index = array_rand($files);

        $file = new File($files[$index]);
        return new UploadedFile($file->getPathname(), $file->getFilename());
    }
}
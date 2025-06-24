<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileHandler
{
    public function __construct(
        private string $targetDirectory,
        private string $publicPath,
        private SluggerInterface $slugger,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        // Get the original filename and create a unique name
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        // Move the file to the directory where files are stored
        $file->move($this->targetDirectory, $fileName);
        
        // Return new filename
        return $fileName;
    }

    public function delete(?string $filename){
        if ($filename == null || $filename == ''){
            return;
        }
        $path = $this->url($filename);
        if (file_exists($path)){
            unlink($path);
        }
    }

    public function url(string $filename): string
    {
        return $this->publicPath . '/' . $filename;
    }
    
}
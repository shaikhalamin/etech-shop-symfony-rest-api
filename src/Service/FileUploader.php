<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;
    private $projectDirectory;

    public function __construct(string $projectDirectory, string $targetDirectory)
    {
        $this->projectDirectory = $projectDirectory;
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file, string $fileName, string $folderPath)
    {
        $newFilename    =  sprintf("%s.%s", strtolower($fileName), $file->guessExtension());
        try {
            $file->move(sprintf('%s%s', $this->getTargetDirectory(), $folderPath), $newFilename);
        } catch (FileException $e) {
            dd($e->getMessage());
        }

        return $newFilename;
    }

    public function getTargetDirectory()
    {
        return sprintf('%s/public%s', $this->projectDirectory, $this->targetDirectory);
    }
}

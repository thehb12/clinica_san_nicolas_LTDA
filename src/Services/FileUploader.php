<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    private $targetDirectoryFiles;
    private $targetDirectoryIconos;
    private $targetDirectoryFotos;
    private $targetDirectoryPdf;


    public function __construct(
        $targetDirectoryFiles,
        $targetDirectoryIconos,
        $targetDirectoryFotos,
        $targetDirectoryPdf
    )
    {
        $this->targetDirectoryFiles = $targetDirectoryFiles;
        $this->targetDirectoryIconos = $targetDirectoryIconos;
        $this->targetDirectoryFotos = $targetDirectoryFotos;
        $this->targetDirectoryPdf = $targetDirectoryPdf;
    }

    public function upload(?UploadedFile $file): string
    {

        if ($file instanceof UploadedFile) {

            $fileName = uniqid() . '.' . $file->guessExtension();

            try {
                $file->move($this->getTargetDirectoryFotos(), $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
                return "";
            }

            return $fileName;
        }

        return "";
    }

    public function uploadIcon(?UploadedFile $file): string
    {
        if ($file instanceof UploadedFile) {
            $fileName = uniqid() . '.' . $file->guessExtension();
            try {
                $file->move($this->getTargetDirectoryIconos(), $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
                return "";
            }
            return $fileName;
        }

        return "";
    }

    public function uploadPdf(?UploadedFile $file): string
    {

        if ($file instanceof UploadedFile) {

            $fileName = uniqid() . '.' . $file->guessExtension();

            try {
                $file->move($this->getTargetDirectoryPdf(), $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
                return "";
            }

            return $fileName;
        }

        return "";
    }



    public function removUploadIcon(?string $path): void
    {

    }

    public function removUploadFoto(?string $path): void
    {
        if (is_file($path)) {
            unlink($path);
        }
    }

    public function removUploadPdf(?string $path): void
    {
        if ($path !== null && is_file($path)) {
            unlink($path);
        }
    }

    public function getTargetDirectoryFiles()
    {
        return $this->targetDirectoryFiles;
    }


    public function getTargetDirectoryIconos()
    {
        return $this->targetDirectoryIconos;
    }

    public function getTargetDirectoryFotos()
    {
        return $this->targetDirectoryFotos;
    }

    public function getTargetDirectoryPdf()
    {
        return $this->targetDirectoryPdf;
    }

}
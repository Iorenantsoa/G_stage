<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploaderPdf {

    public function __construct(private SluggerInterface $slugger)
    {}
    public function uploadPdf( UploadedFile $pdfFile , string $directoryPdf){

        $originalFilename = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pdfFile->guessExtension();
                try {
                    $pdfFile->move(
                        $directoryPdf,
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                return $newFilename;
    }
}

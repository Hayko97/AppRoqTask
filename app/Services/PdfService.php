<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class PdfService implements PdfServiceInterface
{
    public function searchFor(string $word, UploadedFile $file): bool
    {
        // The pseudocode, replace it with actual implementation
        return strpos($this->pdfService->getContent($file), $word) !== false;
    }
}

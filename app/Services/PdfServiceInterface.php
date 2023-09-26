<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface PdfServiceInterface
{
    function searchFor(string $word, UploadedFile $file): bool;
}

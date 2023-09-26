<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadPdfRequest;
use App\Models\PdfFile;
use App\Services\PdfServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

// TODO: Improve this code!

// 1. **Make a Repository:**
// TODO: Create a User Repository and Interface. This helps in managing database queries and makes testing easier.

// 2. **Create a Service:**
// TODO: Create a User Service. This will handle the logic related to users. The service will use the User Repository for any database actions.

// 3. **Write Tests:**
// TODO: Write tests for the User Service to make sure everything works as it should. And feature tests for repositories methods

// 4. **Update Controller:**
// TODO: Change the Controller to use the new Service and fix any errors. Update Swagger Docs as needed.

// 5. **Handle Errors:**
// TODO: Improve how errors are handled. For example, let the user know if the country they provided doesn’t exist.

// 6. **Use Dependency Injection:**
// TODO: Use Dependency Injection for the User Service in the Controller, and link the User Repository Interface to its implementation.

class PdfUploadController extends Controller
{
    public function __construct(private PdfServiceInterface $pdfService)
    {
    }

    public function upload(UploadPdfRequest $request): JsonResponse
    {
        $searchWord = $request->input('word');

        /** @var UploadedFile $file */
        $file = $request->file('file');

        if (!$this->pdfService->searchFor($searchWord, $file)) {
            throw ValidationException::withMessages([
                'file' => "The PDF file must contain the word \"$searchWord\"."
            ])->status(422);
        }

        $existingFile = PdfFile::where('name', $file->getClientOriginalName())
            ->where('size', $file->getSize())
            ->first();

        if ($existingFile) {
            $existingFile->update([
                'content' => $file->getContent(),
            ]);
        } else {
            PdfFile::create([
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'content' => $file->getContent(),
            ]);
        }

        return response()->json(['message' => 'File uploaded successfully.']);
    }
}

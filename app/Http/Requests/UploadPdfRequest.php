<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadPdfRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:pdf|max:10240',
            'word' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'A PDF file is required.',
            'file.mimes' => 'The file must be a PDF.',
            'file.max' => 'The PDF file may not be greater than 10MB.',
            'word.required' => 'A search word is required.',
        ];
    }
}

<?php

namespace App\Http\Requests\FileManager;

use App\Http\Requests\Traits\JsonResponseValidation;
use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    use JsonResponseValidation;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $fileTypes = array_keys(config('app.file_types'));
        $fileTypes[] = 'file';
        $uploadFileSize = config('app.upload_file_size') * 1024 * 1024;

        return [
            'folder_id' => 'required|integer|exists:folders,id',
            'file_type' => 'required|alpha_dash|max:255|in:' . implode(',', $fileTypes),
            'file' => 'required|file|max:' . $uploadFileSize
        ];
    }
}

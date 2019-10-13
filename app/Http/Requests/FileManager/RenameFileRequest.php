<?php

namespace App\Http\Requests\FileManager;

use App\Http\Requests\Traits\JsonResponseValidation;
use Illuminate\Foundation\Http\FormRequest;

class RenameFileRequest extends FormRequest
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
        return [
            'id' => 'required|integer|exists:files,id',
            'name' => 'required|alpha_dash|max:255'
        ];
    }
}

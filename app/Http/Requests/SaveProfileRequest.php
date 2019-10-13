<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\JsonResponseValidation;
use Illuminate\Foundation\Http\FormRequest;

class SaveProfileRequest extends FormRequest
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
        $passwordMinLength = config('app.password_min_length');
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'old_password' => 'string',
            'password' => 'string|min:' . $passwordMinLength,
            'password2' => 'string|same:password|min:' . $passwordMinLength
        ];
    }
}

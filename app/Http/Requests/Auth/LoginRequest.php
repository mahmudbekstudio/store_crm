<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Traits\JsonResponseValidation;
use Illuminate\Foundation\Http\FormRequest;
use function PHPUnit\Framework\StaticAnalysis\HappyPath\AssertIsArray\consume;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|exist_in_website:users|max:255',
            'password' => 'required|min:' . config('app.validation.minimum_password_length'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.exist_in_website' => __('message.email_or_password_is_incorrect'),
        ];
    }
}

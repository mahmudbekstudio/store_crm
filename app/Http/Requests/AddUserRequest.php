<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\JsonResponseValidation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password2' => 'same:password',
            'status' => 'required|in:0,1,2',
            'role' => 'required|in:0,1,2,3'
        ];
    }
}

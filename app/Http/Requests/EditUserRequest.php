<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\JsonResponseValidation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
        $rules = [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'status' => 'required|in:' . implode(',', array_keys(User::getStatuses())),
            'role' => 'required|in:' . implode(',', User::getRoles())
        ];

        if(implode(request()->only(['password', 'password2']))) {
            $rules['password'] = 'required';
            $rules['password2'] = 'same:password';
        }

        return $rules;
    }
}

<?php
namespace App\Http\Requests\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait JsonResponseValidation {
	protected function failedValidation(Validator $validator) {
		throw new HttpResponseException(response()->json(responseMessage(false, $validator->errors())));
	}
}
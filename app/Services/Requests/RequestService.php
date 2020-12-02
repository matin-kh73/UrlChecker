<?php

namespace App\Services\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

abstract class RequestService extends Request
{

    private $validator;

    /**
     * Get the validated data from the request.
     *
     * @return array
     * @throws ValidationException
     */
    public function validated()
    {
        return $this->validator->validated();
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    protected function messages () {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    protected function attributes()
    {
        return [];
    }

    /**
     * @return array|void
     * @throws ValidationException
     */
    public function validate () {
        if (false === $this->authorize()) {
            throw new UnauthorizedException();
        }

        $this->validator = app('validator')->make($this->all(), $this->rules(), $this->messages());

        if ($this->validator->fails()) {
            throw new HttpResponseException(Response::error($this->validator->errors()->all(), 422));
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract protected function rules ();
}

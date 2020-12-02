<?php

namespace App\Http\Requests\Url;


use App\Services\Requests\RequestService;

class UrlUpdateRequest extends RequestService
{
    public function authorize()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function rules()
    {
        return [
            'link' => 'required|url|max:255',
            'description' => 'nullable|string|max:255',
            'result_status' => 'in:0,1'
        ];
    }
}

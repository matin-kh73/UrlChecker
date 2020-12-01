<?php

namespace App\Http\Requests\Url;


use App\Services\Requests\RequestService;

class UrlIndexRequest extends RequestService
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
            'paginate' => 'nullable|in:true,false',
        ];
    }
}

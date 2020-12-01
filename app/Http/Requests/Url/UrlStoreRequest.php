<?php

namespace App\Http\Requests\Url;

use App\Services\Requests\RequestService;
use Illuminate\Support\Facades\Auth;

class UrlStoreRequest extends RequestService
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
            'link' => 'required|url|max:255|unique:urls,link,NULL,id,user_id,'. Auth::id(),
            'description' => 'nullable|string|max:255'
        ];
    }
}

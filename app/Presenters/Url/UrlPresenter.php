<?php

namespace App\Presenters\Url;

use App\Models\Url;
use App\Presenters\Contracts\Presenter;
use UnexpectedValueException;

class UrlPresenter extends Presenter
{
    /**
     *
     * @return string
     */
    public function result_status()
    {
        switch ($this->entity->result_status){
            case Url::RESULT_STATUS['tested'] :
                return 'tested';
            case Url::RESULT_STATUS['untested'] :
                return 'untested';
            default :
                throw new UnexpectedValueException('The result status of url is not valid!');
        }
    }
}

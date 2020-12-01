<?php

namespace App\Presenters\Result;


use App\Models\Result;
use App\Presenters\Contracts\Presenter;
use UnexpectedValueException;

class ResultPresenter extends Presenter
{
    /**
     *
     * @return string
     */
    public function status()
    {
        switch ($this->entity->status){
            case Result::STATUS['success'] :
                return 'success';
            case Result::STATUS['broken'] :
                return 'broken';
            default :
                throw new UnexpectedValueException('The  status of result is not valid!');
        }
    }
}

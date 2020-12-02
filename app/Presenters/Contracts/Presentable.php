<?php

namespace App\Presenters\Contracts;


trait Presentable
{
    protected $presenterInstance;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function present()
    {
        if (!$this->presenter || !class_exists($this->presenter)){
            throw new \Exception('presenter not found!');
        }

        if(!$this->presenterInstance)
        {
            $this->presenterInstance = new $this->presenter($this);
        }

        return $this->presenterInstance;
    }
}

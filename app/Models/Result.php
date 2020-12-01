<?php

namespace App\Models;


use App\Presenters\Contracts\Presentable;
use App\Presenters\Result\ResultPresenter;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use Presentable;

    protected $fillable = [
        'url_id', 'message', 'status'
    ];

    protected $presenter = ResultPresenter::class;

    /**
     * Different modes of a status
     */
    const STATUS = [
       'success' => 1,
       'broken' => 0
    ];

    /**
     * Each result belongs to the url
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function url()
    {
        return $this->belongsTo(Url::class);
    }
}

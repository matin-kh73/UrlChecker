<?php

namespace App\Models;

use App\Presenters\Contracts\Presentable;
use App\Presenters\Url\UrlPresenter;
use Illuminate\Database\Eloquent\Model;


class Url extends Model
{
    use Presentable;

    protected $connection = 'mysql';

    protected $table = 'urls';

    protected $fillable = [
        'user_id', 'link', 'description', 'result_status',
    ];

    protected $presenter = UrlPresenter::class;

    const RESULT_STATUS = [
        'tested' => 1,
        'untested' => 0
    ];

    /**
     * Each url belongs to specific user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Each url has many results
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Return the untested links
     *
     * @param $query
     * @return mixed
     */
    public function scopeUnTestedLinks($query)
    {
        return $query->where('result_status', false);
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function updateResultStatus(bool $status)
    {
        $this->update(['result_status' => $status]);
        return $this;
    }
}

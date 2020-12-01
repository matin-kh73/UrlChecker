<?php

namespace App\Services\Models;

use App\Models\Url;
use Illuminate\Support\Facades\Gate;

class UrlService
{
    /**
     * @var Url
     */
    private $url;

    public function __construct(Url $url)
    {
        $this->url = $url->newQuery();
    }

    /**
     * Index query
     *
     * @param bool $hasPaginate
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    public function index(bool $hasPaginate = false)
    {
        return $this->url
            ->where('user_id', $this->user()->id)
            ->orderBy('created_at', 'DESC')
            ->when($hasPaginate, function ($query) {
                return $query->paginate();
            }, function ($query) {
                return $query->get();
            });
    }

    /**
     * Store query
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->user()->urls()->create($data);
    }

    /**
     * Update query
     *
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $url = $this->url->findOrFail($id);
        Gate::authorize('perform-action', $url);
        return tap($url)->update($data);
    }

    /**
     * Destroy query
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function destroy($id)
    {
        $url = $this->url->findOrFail($id);
        Gate::authorize('perform-action', $url);
        return $url->delete();
    }

    /**
     * Return the auth user
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return auth()->user();
    }
}

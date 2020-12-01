<?php


namespace App\Services\Models;


use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ResultService
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $result;

    public function __construct(Result $result)
    {
        $this->result = $result->newQuery();
    }

    public function index(bool $hasPaginate)
    {
        return $this->result
            ->whereHas('url', function ($query) {
                $query->where('user_id', $this->user()->id);
            })->orderBy('created_at', 'DESC')
            ->when($hasPaginate, function ($query) {
                return $query->paginate();
            }, function ($query) {
                return $query->get();
            });
    }

    public function destroy($id)
    {
        $result = $this->result->findOrFail($id);
        Gate::authorize('result-action', $result);
        return $result->delete();
    }

    public function user()
    {
        return Auth::user();
    }
}

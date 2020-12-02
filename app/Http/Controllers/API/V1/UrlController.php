<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Url\UrlIndexRequest;
use App\Http\Requests\Url\UrlStoreRequest;
use App\Http\Requests\Url\UrlUpdateRequest;
use App\Http\Resources\Url\UrlResource;
use App\Models\Url;
use App\Services\Models\UrlService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UrlController extends Controller
{
    /**
     * @var UrlService
     */
    private $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * Display a listing of the urls.
     *
     * @param UrlIndexRequest $request
     * @return mixed
     */
    public function index(UrlIndexRequest $request)
    {
        try {
            $urls = $this->urlService->index($request->get('paginate', 0));
            return Response::success(UrlResource::collection($urls), 'Urls list was received successfully');
        } catch (\Exception $exception) {
            throw new HttpResponseException(Response::error('Urls list could not be received'));
        }
    }

    /**
     * Store a newly url in storage
     *
     * @param UrlStoreRequest $request
     * @return mixed
     */
    public function store(UrlStoreRequest $request)
    {
        try {
            $url = $this->urlService->store($request->validated());
            return Response::created(new UrlResource($url), 'The Url was created successfully.');
        } catch (\Exception $exception) {
            throw new HttpResponseException(Response::error('Failed to create url, please try again later!'));
        }
    }

    /**
     * @param UrlUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function update(UrlUpdateRequest $request, $id)
    {
        try {
            $url = $this->urlService->update($request->validated(), $id);
            return Response::success(new UrlResource($url), 'The Url was updated successfully.');
        } catch (\Exception $exception) {
            throw new HttpResponseException(Response::error('Failed to update the url, please try again later!'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        try {
            $this->urlService->destroy($id);
            return Response::withoutData('The Url was deleted successfully.');
        } catch (\Exception $exception) {
            throw new HttpResponseException(Response::error('Failed to delete the url, please try again later!'));
        }
    }
}

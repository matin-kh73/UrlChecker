<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\Controller;
use App\Http\Resources\Result\ResultResource;
use App\Services\Models\ResultService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResultController extends Controller
{
    /**
     * @var ResultService
     */
    private $resultService;

    public function __construct(ResultService $resultService)
    {
        $this->resultService = $resultService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $urls = $this->resultService->index($request->get('paginate', 0));
            return Response::success(ResultResource::collection($urls), 'results list was received successfully');
        } catch (\Exception $exception) {
            throw new HttpResponseException(Response::error('results list could not be received'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        try {
            $this->resultService->destroy($id);
            return Response::withoutData('The result was deleted successfully.');
        } catch (\Exception $exception) {
            throw new HttpResponseException(Response::error('Failed to delete the result, please try again later!'));
        }
    }
}

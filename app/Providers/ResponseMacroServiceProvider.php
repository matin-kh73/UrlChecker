<?php


namespace App\Providers;


use Carbon\Laravel\ServiceProvider;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Response::macro('notFound', function ($message = 'Your request not found') {
            return response()->json([
                'status' => false,
                'message' => $message,
            ], Response::HTTP_NOT_FOUND);
        });

        Response::macro('paginate', function (LengthAwarePaginator $paginate, $data, $message = '') {
            return response()->json([
                'status' => true,
                'data' => $data,
                'links' => [
                    'first' => $paginate->url($paginate->onFirstPage()),
                    'last' => $paginate->url($paginate->lastPage()),
                    'prev' => $paginate->previousPageUrl(),
                    'next' => $paginate->nextPageUrl()
                ],
                'meta' => [
                    "current_page" => $paginate->currentPage(),
                    "last_page" => $paginate->lastPage(),
                    'path' => $paginate->path(),
                    'per_page' => $paginate->perPage(),
                    'total' => $paginate->total(),
                ],
                'message' => $message,
            ]);
        });

        Response::macro('badRequest', function ($message = 'Something wrong occurred') {
            return response()->json([
                'status' => false,
                'message' => $message,
            ], Response::HTTP_BAD_REQUEST);
        });

        Response::macro('unAuthorized', function ($message = 'This action is unauthorized.') {
            return response()->json([
                'status' => false,
                'message' => $message,
            ], Response::HTTP_UNAUTHORIZED);
        });

        Response::macro('created', function ($data, $message = 'Entity was created successfully') {
            return response()->json([
                'status' => true,
                'data' => $data,
                'message' => $message,
            ], Response::HTTP_CREATED);
        });

        Response::macro('success', function ($data = [], $message = null) {
            return response()->json([
                'status' => true,
                'data' => $data,
                'message' => $message,
            ], Response::HTTP_OK);
        });

        Response::macro('withoutData', function ($message) {
            return response()->json([
                'status' => true,
                'message' => $message,
            ], Response::HTTP_OK);
        });

        Response::macro('error', function ($message, $code = 500) {
            return response()->json([
                'status' => false,
                'errors' => $message,
            ], $code == 0 ? Response::HTTP_INTERNAL_SERVER_ERROR : $code);
        });
    }
}

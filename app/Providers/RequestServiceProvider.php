<?php


namespace App\Providers;


use App\Services\Requests\RequestService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->afterResolving(RequestService::class, function ($resolved) {
            $resolved->validate();
        });

        $this->app->resolving(RequestService::class, function ($request, $app) {
            $this->initializeRequest($request, $app['request']);
        });
    }

    /**
     * Initialize the form request with data from the given request.
     *
     * @param RequestService $form
     * @param Request $current
     * @return void
     */
    protected function initializeRequest(RequestService $form, Request $current)
    {
        $files = $current->files->all();
        $files = is_array($files) ? array_filter($files) : $files;
        $form->initialize(
            $current->query->all(), $current->request->all(), $current->attributes->all(),
            $current->cookies->all(), $files, $current->server->all(), $current->getContent()
        );
        $form->setJson($current->json());
        $form->setUserResolver($current->getUserResolver());
        $form->setRouteResolver($current->getRouteResolver());
    }
}

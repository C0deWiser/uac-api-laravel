<?php


namespace Codewiser\UAC\Laravel;

use Illuminate\Routing\Router;

class ApiServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootMiddleware();
    }

    private function bootMiddleware()
    {
        /** @var Router $router */
        $router = $this->app['router'];
        $router->aliasMiddleware('auth.token_introspection', TokenIntrospection::class);
    }
}
<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Token;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\RouteRegistrar;

class PassportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes()
            ->tokenLifetime()
            ->overrideModels()
            ->hashClientSecret();
    }

    /**
     * Setup laravel passport routes.
     *
     * @return $this
     */
    protected function routes()
    {
        if (! $this->app->routesAreCached()) {
            Passport::routes(function (RouteRegistrar $router) {
                // Handle client credential and password grants routes
                $router->forAccessTokens();
                // Handle refresh tokens routes
                $router->forTransientTokens();
            });
        }

        return $this;
    }

    /**
     * Set laravel passport token lifetime.
     *
     * @return $this
     */
    protected function tokenLifetime()
    {
        Passport::tokensExpireIn(now()->addweeks(4));
        Passport::refreshTokensExpireIn(now()->addweeks(12));

        return $this;
    }

    /**
     * Override laravel passport default models.
     *
     * @return $this
     */
    protected function overrideModels()
    {
        Passport::useClientModel(Client::class);
        Passport::useTokenModel(Token::class);

        return $this;
    }

    /**
     * Hashing client secret.
     * All of your client secrets will only be displayable to the user immediately after they are created.
     * Since the plain-text client secret value is never stored in the database,
     * It's not possible to recover the secret's value if it is lost.
     *
     * @return $this
     */
    protected function hashClientSecret()
    {
        Passport::hashClientSecrets();

        return $this;
    }
}

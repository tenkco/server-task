<?php
namespace Src\Provider;

use Src\Provider\AbstractProvider;
use Src\Route;

class RouteProvider extends AbstractProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->app->bind('route', Route::single()->setPrefix($this->app->settings->getRootPath()));

        if ($this->checkPrefix('/api')) {
            $this->app->settings->removeAppMiddleware('csrf');
            $this->app->settings->removeAppMiddleware('specialChars');

            Route::group('/api', function () {
                require_once __DIR__ . '/../../../routes/api.php';
            });
            return;
        }
        require_once __DIR__ . '/../../../routes/web.php';
    }

    private function getUri(): string
    {
        return substr($_SERVER['REQUEST_URI'], strlen($this->app->settings->getRootPath()));
    }

    private function checkPrefix(string $prefix): bool
    {
        $uri = $this->getUri();
        return strpos($uri, $prefix) === 0;
    }
}
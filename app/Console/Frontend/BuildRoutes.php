<?php

namespace App\Console\Commands\Frontend;

use Illuminate\Routing\Router;

class BuildRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'platform:frontend:routes';

    /**
     * Name of the created file.
     *
     * @var string
     */
    protected $targetFilename = 'routes.json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build routes for frontend (put all routes into a .json file).';

    /**
     * Export data into json file.
     *
     * @return array
     */
    public function export(): array
    {
        return [
            'routes'  => (string) $this->getRoutes(),
            'baseUrl' => rtrim(config('app.url'), '/') . '/',
        ];
    }

    /**
     * Routes collection.
     *
     * @return static
     */
    private function getRoutes()
    {
        return collect(app(Router::class)->getRoutes()->getRoutesByName())
            ->map(function ($route) {
                return collect($route)
                    ->only(['uri', 'methods'])
                    ->put('domain', $route->domain());
            });
    }
}

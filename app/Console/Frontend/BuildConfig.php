<?php

namespace App\Console\Commands\Frontend;

use Arr;

class BuildConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'platform:frontend:config';

    /**
     * Name of the created file.
     *
     * @var string
     */
    protected $targetFilename = 'config.json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build configs for frontend (put selected configs into a .json file).';

    /**
     * List of all configs that should be passed to frontend.
     *
     * @var array
     */
    protected $configs = [
        'app.version',
        'lang.list' => 'app.locale_list',
        'token.refresh_lifetime' => 'app.refresh_token_lifetime',
        'token.access_lifetime' => 'jwt.ttl',
        'app.name',
        'app.env',
        'app.debug',
        'app.url',
        'app.asset_url',
        'app.timezone',
        'lang.locale' => 'app.locale',
        'lang.fallback_locale' => 'app.fallback_locale',
        'token.type' => 'app.token_type',
        'token.field' => 'app.token_field',
        'validation' => 'app.validation'
    ];

    /**
     * Export data into json file.
     *
     * @return array
     */
    public function export(): array
    {
        return $this->getConfigs();
    }

    /**
     * Get all configs.
     *
     * @return array
     */
    protected function getConfigs(): array
    {
        $configs = [];

        foreach ($this->configs as $key => $config) {
            $key = is_string($key) ? $key : $config;
            Arr::set($configs, $key, config($config));
        }

        return $configs;
    }
}

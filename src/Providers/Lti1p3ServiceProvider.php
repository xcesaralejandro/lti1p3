<?php 
namespace xcesaralejandro\lti1p3\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use xcesaralejandro\lti1p3\Classes\JWT;
use xcesaralejandro\lti1p3\Classes\Launch;
use xcesaralejandro\lti1p3\Classes\Lti;
use xcesaralejandro\lti1p3\Classes\Message;

class Lti1p3ServiceProvider extends ServiceProvider {

    public function boot(){
        $this->loadViewsFrom($this->packageBasePath('resources/views'), "lti1p3");

        $this->loadRoutesFrom($this->packageBasePath('routes/web.php'));

        $this->loadRoutesFrom($this->packageBasePath('routes/api.php'));

        $router = $this->app['router'];
        $router->aliasMiddleware('lti_instance_recovery', 'xcesaralejandro\\lti1p3\\Http\\Middleware\\InstanceRecovery::class');

        $this->loadTranslationsFrom($this->packageBasePath('resources/lang'), 'lti1p3');

        $this->publishes([
            $this->packageBasePath('resources/views') => resource_path("/views/vendor/lti1p3")
        ], 'xcesaralejandro-lti1p3-views');
        
        $this->publishes([
            $this->packageBasePath('config/lti1p3.php') => base_path("config/lti1p3.php")
        ], 'xcesaralejandro-lti1p3-config');

        $this->publishes([
            $this->packageBasePath('database/migrations') => database_path('migrations')
        ], 'xcesaralejandro-lti1p3-migrations');

        $this->publishes([
            $this->packageBasePath('public') => public_path()
        ], 'xcesaralejandro-lti1p3-assets');

        $this->publishes([
            $this->packageBasePath('resources/lang') => resource_path('lang/vendor/lti1p3')
        ], 'xcesaralejandro-lti1p3-translations');

        $this->publishes([
            $this->packageBasePath('Http/Controllers/publish') => base_path('app/Http/Controllers')
        ], 'xcesaralejandro-lti1p3-controller');

        $this->publishes([
            $this->packageBasePath('src/Models/publish') => base_path('app/Models')
        ], 'xcesaralejandro-lti1p3-models');

        $this->publishes([
            $this->packageBasePath('database/seeders') => database_path('seeders')
        ], 'xcesaralejandro-lti1p3-seeder');
    }

    public function register(){
        $this->app->bind('launch', function(){
            return new Launch();
        });

        $this->app->bind('jwt', function(){
            return new JWT();
        });

        $this->mergeConfigFrom($this->packageBasePath('config/lti1p3.php'), "lti1p3");
        $this->loadMigrationsFrom($this->packageBasePath('database/migrations'));

        Blade::directive('addinstance', function ($instance_id) {
            return '<input type="hidden" name="lti1p3-instance-id" value="'."<?php echo $instance_id; ?>".'" />';
        });
    }

    protected function packageBasePath($uri){
        return __DIR__."/../../$uri";
    }
}
<?php 
namespace xcesaralejandro\lti1p3\Tests;

use Hello;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use xcesaralejandro\lti1p3\Providers\Lti1p3ServiceProvider;

class TestCase extends TestbenchTestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            Lti1p3ServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
        ];
    }


    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('app.key','base64:TqMyAe8a56l6JmLhbf7LTDzXI2lbazAGaGDAO7wqLHs=');
        $app['config']->set('database.default', 'packagedb');
        $app['config']->set('database.connections.packagedb', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
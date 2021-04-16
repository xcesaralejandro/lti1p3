<?php 
namespace xcesaralejandro\lti1p3\Tests;

use Hello;
use xcesaralejandro\lti1p3\Providers\CmoraLtiServiceProvider;
use xcesaralejandro\lti1p3\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

/*
    Para utilizar los tests, es necesario incluir los providers y los aliases
    de nuestro paquete, luego de incluir el alias (facade) hay que añadir 
    tambien el nombre de la clase para que la reconozca. "use NombreDelAlias;"
    
    Esta clase sobrescribe los tests de Orchestra para luego extender de esta 
    clase los test manteniendo centralizando y reutilizando nuestras cargas
    personalizadas de facades y providers.

    Para correr los tests:
    "vendor/bin/phpunit" src/Tests/HelloTest.php
  */
class TestCase extends TestbenchTestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            CmoraLtiServiceProvider::class,
            RouteServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Hello' => 'xcesaralejandro\lti1p3\Facades\Hello'
        ];
    }




    // Las siguientes configuraciones nos permiten tener una base de datos en memoria
    // para poder testear nuestro paquete, del contrario podemos hacerlo desde la 
    // aplicación de laravel.
    // Una alternativa a setUp es utilizar el trait RefreshDatabase (use RefreshDatabase;)
    // en ese caso dicha función no iria, pero la base de datos reiniciaria cada vez
    // en las pruebas, ahora es una cosa de gustos y necesidades.

    // public function setUp(): void
    // {
    //     parent::setUp();
    //     $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    //     $this->artisan('migrate', ['--database' => 'packagedb'])->run();

    // }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'packagedb');
        $app['config']->set('database.connections.packagedb', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
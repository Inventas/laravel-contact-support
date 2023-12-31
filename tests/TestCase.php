<?php

namespace Inventas\ContactSupport\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Inventas\ContactSupport\ContactSupportServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Inventas\\ContactSupport\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ContactSupportServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/create_contact_support_table.php.stub';
        $migration->up();

    }
}

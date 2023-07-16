<?php

namespace Inventas\ContactSupport;

use Inventas\ContactSupport\Providers\EventServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Inventas\ContactSupport\Commands\ContactSupportCommand;

class ContactSupportServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-contact-support')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-contact-support_table')
            ->hasCommand(ContactSupportCommand::class);
    }

    public function register()
    {
        $this->app->register(EventServiceProvider::class);

        return parent::register();
    }
}

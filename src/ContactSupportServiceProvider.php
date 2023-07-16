<?php

namespace Inventas\ContactSupport;

use Inventas\ContactSupport\Providers\EventServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasMigration('create_contact_support_table');

    }

    public function registeringPackage()
    {
        parent::registeringPackage(); // TODO: Change the autogenerated stub

        $this->app->register(EventServiceProvider::class);
    }
}

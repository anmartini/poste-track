<?php

namespace Anmartini\PosteTrack;

use Anmartini\PosteTrack\Commands\PosteTrackCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PosteTrackServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('poste-track')
            ->hasConfigFile()
            ->hasCommand(PosteTrackCommand::class);
    }
}

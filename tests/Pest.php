<?php

use Anmartini\PosteTrack\Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

uses(TestCase::class)->in(__DIR__);

beforeEach(function () {
    Factory::guessFactoryNamesUsing(
        fn (string $modelName) => 'Anmartini\\PosteTrack\\Database\\Factories\\'.class_basename($modelName).'Factory'
    );
});

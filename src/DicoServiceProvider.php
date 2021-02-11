<?php

namespace Alis\Dico;

use Alis\Dico\Http\Livewire\DictionaryManager;
use Alis\Dico\Http\Livewire\TypeDictionaryManager;
use Alis\Dico\View\Components\DicoDescriptionField;
use Alis\Dico\View\Components\DicoSelect;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

class DicoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/dico.php', 'dico');

        $this->app->afterResolving(BladeCompiler::class, function () {
            if (config('dico.stack') === 'livewire' && class_exists(Livewire::class)) {
                Livewire::component('dico.dictionary', DictionaryManager::class);
                Livewire::component('dico.type-dictionary', TypeDictionaryManager::class);
            }
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->viewPublishing();

        $this->migrationPublishing();

        // $this->makeFactory();

        $this->callAfterResolving(BladeCompiler::class, function () {
            Blade::component('dico-description-field', DicoDescriptionField::class);
            Blade::component('dico-select', DicoSelect::class);
        });

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'dicoLang');

        $this->publishes([
            __DIR__.'/../config/dico.php' => config_path('dico.php'),
        ], 'dico-config');

    }

    private function migrationPublishing()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../database/migrations/2013_09_12_092853_create_type_dictionaries_table.php' => database_path('migrations/2013_09_12_092853_create_type_dictionaries_table.php'),
            __DIR__.'/../database/migrations/2013_09_12_092922_create_dictionaries_table.php' => database_path('migrations/2013_09_12_092922_create_dictionaries_table.php'),
        ], 'dico-migrations');
    }

    private function viewPublishing()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'dico');

        if (config('dico.stack') === 'livewire' && class_exists(Livewire::class)) {
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/dico'),
            ], 'dico-views');
        }
    }

    private function makeFactory()
    {
        $version = (explode('.', app()->version()))[0];

        if ($version < 8) {
            $path = 'Illuminate\Database\Eloquent\Factory';
        } else {
            $path = 'Illuminate\Database\Eloquent\Factories\Factory';
        }

        $this->app->make($path)
            ->load(__DIR__.'/../database/factories');
    }
}

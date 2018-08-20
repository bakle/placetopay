<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('PText', 'components.form.text', ['name', 'label', 'value' => null, 'attributes' => [], 'col_size' => '']);
        Form::component('PSelect', 'components.form.select', ['name', 'label', 'data', 'value' => null, 'attributes' => [], 'col_size' => '']);
        Form::component('PEmail', 'components.form.email', ['name', 'label', 'value' => null, 'attributes' => [], 'col_size' => '']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

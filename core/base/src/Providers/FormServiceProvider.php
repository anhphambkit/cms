<?php

namespace Core\Base\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     * @return void
     * @author Sang Nguyen
     */
    public function boot()
    {
        Form::component('error', 'core-base::elements.forms.error', [
            'name',
            'errors' => null,
        ]);
    }
}

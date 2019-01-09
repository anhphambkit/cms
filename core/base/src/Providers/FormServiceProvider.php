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
        Form::component('modalAction', 'core-base::elements.forms.modal', [
            'name',
            'title',
            'type' => null,
            'content' => null,
            'action_id' => null,
            'action_name' => null,
        ]);

        Form::component('error', 'core-base::elements.forms.error', [
            'name',
            'errors' => null,
        ]);
    }
}

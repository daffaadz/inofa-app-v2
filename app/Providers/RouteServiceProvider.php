<?php

use App\Models\ProjectAgreement;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        Route::model('agreement', ProjectAgreement::class);
    }
}

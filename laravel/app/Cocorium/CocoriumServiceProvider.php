<?php namespace Cocorium;


use Illuminate\Support\ServiceProvider;

class CocoriumServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind(
            'Cocorium\Payment\PaymentInterface',
            'Cocorium\Payment\PaymentMaxCollectDriver'
        );
    }
}
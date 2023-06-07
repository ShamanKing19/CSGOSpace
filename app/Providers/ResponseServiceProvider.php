<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\Response::macro('success', function(array $data = [], int $status = 200) {
            $response = ['success' => true];
            if($data) {
                $response['data'] = $data;
            }

            return \Illuminate\Support\Facades\Response::make($response)->setStatusCode($status);
        });

        \Illuminate\Support\Facades\Response::macro('error', function(string $message = 'Something went wrong...', array $data = [], int $status = 400) {
            $response = [
                'success' => false,
                'error' => $message
            ];
            if($data) {
                $response['data'] = $data;
            }

            return \Illuminate\Support\Facades\Response::make($response)->setStatusCode($status);
        });
    }
}

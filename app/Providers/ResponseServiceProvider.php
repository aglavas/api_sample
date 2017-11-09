<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{

    /**
     * Define response macros
     */
    public function boot()
    {
        Response::macro('success', function ($data, $status = 200) {
            return Response::json([
              'status_code'  => $status,
              'data' => $data,
            ], $status);
        });

        Response::macro('successPlan', function ($data, $next, $status = 200) {
            return Response::json([
              'status_code'  => $status,
              'data' => $data,
              'next' => $next,
            ], $status);
        });


        Response::macro('successMessage', function ($data, $status = 200) {
            return Response::json([
              'status_code'  => $status,
              'message' => $data,
            ], $status);
        });

        Response::macro('error', function ($message, $status = 400) {
            return Response::json(
                [
                    'error' => [
                        [
                            'type' => "general",
                            'field' => null,
                            'message' => $message
                        ]
                    ]
                ],
                $status
            );
        });
    }
}

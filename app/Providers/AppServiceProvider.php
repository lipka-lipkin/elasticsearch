<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \DB::listen(function ($query) {
            $sql = array_reduce($query->bindings, function($sql, $binding){
                if($binding instanceof \DateTime)
                {
                    $binding = \Carbon\Carbon::instance($binding);
                }
                return preg_replace('/\?/', is_numeric($binding) ? $binding : "'".$binding."'" , $sql, 1);
            }, $query->sql);
            \Log::info($sql);
        });
    }
}

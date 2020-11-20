<?php

namespace App\Providers;

use App\Models\Article;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        Relation::morphMap([
            'article' => Article::class,
        ]);

        $this->listenDataBaseEvents();
    }

    private function listenDataBaseEvents(){
        if (!app()->isProduction()) {
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
}

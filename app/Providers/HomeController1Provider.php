<?php

namespace App\Providers;

use App\Http\Contracts\FaqContract;
use Illuminate\Support\ServiceProvider;
use App\Http\Response\IndexResponse;
use App\Http\Contracts\IndexContracts;
use App\Http\Contracts\PostsContract;
use App\Http\Response\FaqResponse;
use App\Http\Response\PostsResponse;

class HomeController1Provider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {



        $this->app->bind(IndexContracts::class, IndexResponse::class);
        $this->app->bind(PostsContract::class, PostsResponse::class);
        $this->app->bind(FaqContract::class, FaqResponse::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

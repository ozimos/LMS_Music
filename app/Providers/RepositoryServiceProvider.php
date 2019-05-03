<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(\App\Contracts\Repositories\ProfileRepository::class, \App\Repositories\Eloquent\ProfileRepositoryEloquent::class);
        $this->app->bind(\App\Contracts\Repositories\ArtisteRepository::class, \App\Repositories\Eloquent\ArtisteRepositoryEloquent::class);
        $this->app->bind(\App\Contracts\Repositories\GenreRepository::class, \App\Repositories\Eloquent\GenreRepositoryEloquent::class);
        $this->app->bind(\App\Contracts\Repositories\SongRepository::class, \App\Repositories\Eloquent\SongRepositoryEloquent::class);
        $this->app->bind(\App\Contracts\Repositories\AlbumRepository::class, \App\Repositories\Eloquent\AlbumRepositoryEloquent::class);
        $this->app->bind(\App\Contracts\Repositories\CommentRepository::class, \App\Repositories\Eloquent\CommentRepositoryEloquent::class);
        $this->app->bind(\App\Contracts\Repositories\RatingRepository::class, \App\Repositories\Eloquent\RatingRepositoryEloquent::class);
        $this->app->bind(\App\Contracts\Repositories\PlaylistRepository::class, \App\Repositories\Eloquent\PlaylistRepositoryEloquent::class);
        $this->app->bind(\App\Contracts\Repositories\PaymentRepository::class, \App\Repositories\Eloquent\PaymentRepositoryEloquent::class);
        //:end-bindings:
    }
}

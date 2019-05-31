<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Contracts\Repositories\GenreRepository;
use App\Repositories\Eloquent\GenreRepositoryEloquent;
use App\Contracts\Repositories\SongRepository; 
use App\Repositories\Eloquent\SongRepositoryEloquent;
use App\Contracts\Repositories\AlbumRepository; 
use App\Repositories\Eloquent\AlbumRepositoryEloquent;
use App\Contracts\Repositories\CommentRepository; 
use App\Repositories\Eloquent\CommentRepositoryEloquent;
use App\Contracts\Repositories\RatingRepository; 
use App\Repositories\Eloquent\RatingRepositoryEloquent;
use App\Contracts\Repositories\PlaylistRepository; 
use App\Repositories\Eloquent\PlaylistRepositoryEloquent;
use App\Contracts\Repositories\PaymentRepository; 
use App\Repositories\Eloquent\PaymentRepositoryEloquent;
use App\Contracts\Repositories\UserRepository; 
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\Contracts\Repositories\ProfileRepository; 
use App\Repositories\Eloquent\ProfileRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        GenreRepository::class => GenreRepositoryEloquent::class,
        SongRepository::class => SongRepositoryEloquent::class,
        AlbumRepository::class => AlbumRepositoryEloquent::class,
        CommentRepository::class => CommentRepositoryEloquent::class,
        RatingRepository::class => RatingRepositoryEloquent::class,
        PlaylistRepository::class => PlaylistRepositoryEloquent::class,
        PaymentRepository::class => PaymentRepositoryEloquent::class,
        UserRepository::class => UserRepositoryEloquent::class,
        ProfileRepository::class => ProfileRepositoryEloquent::class,
    ];

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            GenreRepository::class,
            SongRepository::class,
            AlbumRepository::class,
            CommentRepository::class,
            RatingRepository::class,
            PlaylistRepository::class,
            PaymentRepository::class,
            UserRepository::class,
            ProfileRepository::class,
        ];
    }
}

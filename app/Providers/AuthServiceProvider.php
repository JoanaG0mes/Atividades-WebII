<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\User;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use App\Policies\BookPolicy;
use App\Policies\UserPolicy;
use App\Policies\AuthorPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\PublisherPolicy;
use Illuminate\Support\Facades\Gate; // Importe o Gate
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Book::class => BookPolicy::class,
        User::class => UserPolicy::class,
        Author::class => AuthorPolicy::class,
        Category::class => CategoryPolicy::class,
        Publisher::class => PublisherPolicy::class,
    ];


    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}

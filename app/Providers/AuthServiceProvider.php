<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Comment;
use App\Policies\CommentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Comment::class => CommentPolicy::class,
    ];
        

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}

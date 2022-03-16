<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\BaseRepositoryInterface;
use Repository\BaseRepository;
use App\Services\Contracts\BaseServiceInterface;
use Service\BaseService;
use App\Repositories\Contracts\UserRepositoryInterface;
use Repository\UserRepository;
use Service\AuthService;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use Service\UserService;
use Repository\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Service\CategoryService;
use App\Services\Contracts\CategoryServiceInterface;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Repositories\Contracts\IdeaRepositoryInterface;
use App\Services\Contracts\DepartmentServiceInterface;
use App\Services\Contracts\IdeaServiceInterface;
use Repository\DepartmentRepository;
use Repository\IdeaRepository;
use Service\DepartmentService;
use Service\IdeaService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(BaseServiceInterface::class, BaseService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(DepartmentServiceInterface::class, DepartmentService::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(IdeaRepositoryInterface::class, IdeaRepository::class);
        $this->app->bind(IdeaServiceInterface::class, IdeaService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

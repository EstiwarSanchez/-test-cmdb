<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\CmdbRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\CmdbRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CmdbRepositoryInterface::class, CmdbRepository::class);
    }
}

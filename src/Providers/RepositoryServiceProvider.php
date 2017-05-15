<?php namespace Edutalk\Base\ACL\Providers;

use Illuminate\Support\ServiceProvider;
use Edutalk\Base\ACL\Models\Permission;
use Edutalk\Base\ACL\Models\Role;
use Edutalk\Base\ACL\Repositories\Contracts\PermissionRepositoryContract;
use Edutalk\Base\ACL\Repositories\Contracts\RoleRepositoryContract;
use Edutalk\Base\ACL\Repositories\PermissionRepository;
use Edutalk\Base\ACL\Repositories\PermissionRepositoryCacheDecorator;
use Edutalk\Base\ACL\Repositories\RoleRepository;
use Edutalk\Base\ACL\Repositories\RoleRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RoleRepositoryContract::class, function () {
            $repository = new RoleRepository(new Role);

            if (config('edutalk-caching.repository.enabled')) {
                return new RoleRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
        $this->app->bind(PermissionRepositoryContract::class, function () {
            $repository = new PermissionRepository(new Permission);

            if (config('edutalk-caching.repository.enabled')) {
                return new PermissionRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}

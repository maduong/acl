<?php namespace Edutalk\Base\ACL\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'edutalk-acl';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function booted()
    {
        acl_permission()
            ->registerPermission('View roles', 'view-roles', $this->module)
            ->registerPermission('Create roles', 'create-roles', $this->module)
            ->registerPermission('Edit roles', 'edit-roles', $this->module)
            ->registerPermission('Delete roles', 'delete-roles', $this->module)
            ->registerPermission('View permissions', 'view-permissions', $this->module)
            ->registerPermission('Assign roles', 'assign-roles', $this->module);
    }
}

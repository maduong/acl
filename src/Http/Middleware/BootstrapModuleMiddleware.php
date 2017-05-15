<?php namespace Edutalk\Base\ACL\Http\Middleware;

use \Closure;

class BootstrapModuleMiddleware
{
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  array|string $params
     * @return mixed
     */
    public function handle($request, Closure $next, ...$params)
    {
        /**
         * Register to dashboard menu
         */
        dashboard_menu()->registerItem([
            'id' => 'edutalk-acl-roles',
            'priority' => 3.1,
            'parent_id' => null,
            'heading' => null,
            'title' => trans('edutalk-acl::base.roles'),
            'font_icon' => 'icon-lock',
            'link' => route('admin::acl-roles.index.get'),
            'css_class' => null,
            'permissions' => ['view-roles'],
        ])->registerItem([
            'id' => 'edutalk-acl-permissions',
            'priority' => 3.2,
            'parent_id' => null,
            'heading' => null,
            'title' => trans('edutalk-acl::base.permissions'),
            'font_icon' => 'icon-shield',
            'link' => route('admin::acl-permissions.index.get'),
            'css_class' => null,
            'permissions' => ['view-permissions'],
        ]);

        admin_quick_link()->register('role', [
            'title' => trans('edutalk-acl::base.role'),
            'url' => route('admin::acl-roles.create.get'),
            'icon' => 'icon-lock',
        ]);

        return $next($request);
    }
}

<?php namespace Edutalk\Base\ACL\Http\Controllers;

use Illuminate\Http\Request;
use Edutalk\Base\ACL\Http\DataTables\PermissionsListDataTable;
use Edutalk\Base\Http\Controllers\BaseAdminController;
use Edutalk\Base\ACL\Repositories\Contracts\PermissionRepositoryContract;

class PermissionController extends BaseAdminController
{
    protected $module = 'edutalk-acl';

    /**
     * @var \Edutalk\Base\ACL\Repositories\PermissionRepository
     */
    protected $repository;

    public function __construct(PermissionRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu($this->module . '-permissions');

            $this->breadcrumbs
                ->addLink(trans('edutalk-acl::base.acl'))
                ->addLink(trans('edutalk-acl::base.permissions'), route('admin::acl-permissions.index.get'));

            return $next($request);
        });
    }

    public function getIndex(PermissionsListDataTable $permissionsListDataTable)
    {
        $this->setPageTitle(trans('edutalk-acl::base.permissions'));

        $this->dis['dataTable'] = $permissionsListDataTable->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, Edutalk_ACL_PERMISSION, 'index.get')->viewAdmin('permissions.index');
    }

    public function postListing(PermissionsListDataTable $permissionsListDataTable)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $permissionsListDataTable, Edutalk_ACL_PERMISSION, 'index.post', $this);
    }
}

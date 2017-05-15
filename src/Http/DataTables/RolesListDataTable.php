<?php namespace Edutalk\Base\ACL\Http\DataTables;

use Edutalk\Base\ACL\Models\Role;
use Edutalk\Base\Http\DataTables\AbstractDataTables;
use Yajra\Datatables\Engines\CollectionEngine;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Engines\QueryBuilderEngine;

class RolesListDataTable extends AbstractDataTables
{
    /**
     * @var Role
     */
    protected $model;

    public function __construct()
    {
        $this->model = Role::select('id', 'name', 'slug');
    }

    /**
     * @return array
     */
    public function headings()
    {
        return [
            'id' => [
                'title' => 'ID',
                'width' => '1%',
            ],
            'name' => [
                'title' => trans('edutalk-acl::datatables.role.heading.name'),
                'width' => '50%',
            ],
            'slug' => [
                'title' => trans('edutalk-acl::datatables.role.heading.slug'),
                'width' => '30%',
            ],
            'actions' => [
                'title' => trans('edutalk-core::datatables.heading.actions'),
                'width' => '20%',
            ],
        ];
    }

    /**
     * @return array
     */
    public function columns()
    {
        return [
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'viewID', 'name' => 'id'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'slug', 'name' => 'slug'],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->setAjaxUrl(route('admin::acl-roles.index.post'), 'POST');

        $this
            ->addFilter(1, form()->text('id', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => '...'
            ]))
            ->addFilter(2, form()->text('name', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('edutalk-core::datatables.search') . '...',
            ]))
            ->addFilter(3, form()->text('slug', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('edutalk-core::datatables.search') . '...',
            ]));

        $this->withGroupActions([
            '' => trans('edutalk-core::datatables.select') . '...',
            'deleted' => trans('edutalk-core::datatables.delete_these_items'),
        ]);

        return $this->view();
    }

    /**
     * @return CollectionEngine|EloquentEngine|QueryBuilderEngine|mixed
     */
    protected function fetchDataForAjax()
    {
        return datatable()->of($this->model)
            ->rawColumns(['actions'])
            ->editColumn('id', function ($item) {
                return form()->customCheckbox([
                    ['id[]', $item->id]
                ]);
            })
            ->addColumn('viewID', function ($item) {
                return $item->id;
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $deleteLink = route('admin::acl-roles.delete.delete', ['id' => $item->id]);
                $editLink = route('admin::acl-roles.edit.get', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to($editLink, trans('edutalk-core::datatables.edit'), ['class' => 'btn btn-outline green btn-sm']);
                $deleteBtn = ($item->status != 'deleted') ? form()->button(trans('edutalk-core::datatables.delete'), [
                    'title' => trans('edutalk-core::datatables.delete_this_item'),
                    'data-ajax' => $deleteLink,
                    'data-method' => 'DELETE',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                ]) : '';

                $deleteBtn = ($item->status != 'deleted') ? $deleteBtn : '';

                return $editBtn . $deleteBtn;
            });
    }
}

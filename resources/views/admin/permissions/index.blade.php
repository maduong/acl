@extends('edutalk-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="icon-layers font-dark"></i>
                {{ trans('edutalk-acl::base.all_permissions') }}
            </h3>
        </div>
        <div class="box-body">
            {!! $dataTable or '' !!}
        </div>
    </div>
    @php do_action(BASE_ACTION_META_BOXES, 'main', Edutalk_ACL_PERMISSION . '.index', null) @endphp
@endsection

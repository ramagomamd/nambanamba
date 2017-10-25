@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.singles.management') .' - '. trans('labels.backend.music.singles.view'))

@section('after-styles')
    
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.singles.management') }}
        <small>{{ trans('labels.backend.music.singles.view') }}</small>
    </h1>
@endsection

@section('content')

<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ trans('labels.backend.music.singles.view') }}
            <small>{{ $single->title }}</small>
        </h3>

        <div class="box-tools pull-right">
            @include('backend.music.partials.single-header-buttons')
        </div><!--box-tools pull-right-->
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="col-sm-12 col-md-9" align="center">
            {!! $single->tracks_list !!}
        </div>
    </div>
</div>

<div class="box box-danger">
    <div class="box-body">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-footer">
                <p>Created: <em>{{ $single->created_at->diffForHumans() }}</em></p>
                <p>Edited: <em>{{ $single->updated_at->diffForHumans() }}</em></p>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

@if ($single->categories->isNotEmpty())
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            @if ($single->categories->count() == 1)
                <strong>{{ str_singular(trans('labels.backend.music.singles.categories')) }}</strong>
            @else
                <strong>{{ trans('labels.backend.music.singles.categories') }}</strong>
            @endif
            <small>{{ $single->title }}</small>
        </h3>
    </div>

    <div class="box-body">
        <div class="list-group">
        @foreach ($single->categories as $category)
           <a href="{{ route('admin.music.categories.show', $category->id) }}" class="list-group-item">
            <strong><span class="fa fa-folder"></span> {{ $category->name }}</strong></a> 
        @endforeach
        </div>
        <div class="clearfix"></div>
    </div><!-- /.box-body -->
</div><!--box-->
@endif

<div class="box box-info">
    <div class="box-body">
        <div class="pull-left">
            {!! $single->delete_action !!}
        </div><!--pull-left-->

        <div class="pull-right">
            <a href="{{ route('admin.music.singles.edit', $single) }}" class="btn btn-success btn-md"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="{{ trans('buttons.general.crud.edit') }}"></i> {{ trans('buttons.general.crud.edit') }}</a>
        </div><!--pull-right-->

        <div class="clearfix"></div>
    </div><!-- /.box-body -->
</div><!--box-->

@endsection

@section('after-scripts')

@endsection
@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.singles.management') .' - '. $title)

@section('after-styles')
    
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.singles.management') }}
        <small>{{ $title }}</small>
    </h1>
@endsection

@section('content')

<div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>

            <div class="box-tools pull-right">
                @include('backend.music.partials.single-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            @if ($tracks->isNotEmpty())
                <div class="table-responsive"
                    style="margin-left: 10px; margin-right: 10px; margin-top: 10px">
                <table id="users-table" class="table table-striped table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.music.singles.table.id') }}</th>
                            <th>{{ trans('labels.backend.music.singles.table.title') }}</th>
                            <th>{{ trans('labels.backend.music.singles.table.categories') }}</th>
                            <th>{{ trans('labels.backend.music.singles.table.genres') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($tracks as $track)
                        <tr>
                            <td>{{ $track->trackable->id }}</td>
                            <td>{!! $track->trackable->track->full_title !!}</td>
                            <td>{{ $track->trackable->category_names }}</td>
                            <td>{{ $track->trackable->genre_names }}</td>
                            <td>{!! $track->trackable->action_buttons !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix"></div>
            </div>
            @else
            <p class="lead">No Singles Yet</p>
            @endif
        </div><!-- /.box-body -->
        
    </div>

@endsection

@section('after-scripts')

@endsection
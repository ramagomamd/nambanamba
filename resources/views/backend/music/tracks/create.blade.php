@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.tracks.management' .' '. trans('labels.backend.music.tracks.create')))

@section('after-styles')
    
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.tracks.management') }}
        <small>{{ trans('labels.backend.music.tracks.create') }}</small>
    </h1>
@endsection

@section('content')


@endsection

@section('after-scripts')

@endsection
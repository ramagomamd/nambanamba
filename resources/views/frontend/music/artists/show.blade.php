@extends('frontend.layouts.app')

@section('title', "{$title} - " . app_name())

@section('meta')
    {!! SEOMeta::generate(true) !!}
    {!! OpenGraph::generate(true) !!}
    {!! Twitter::generate(true) !!}
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.artists.management') }}
        <small>{!! $artist->name !!}</small>
    </h1>
@endsection

@section('content')             
    <div class="col-md-12">
        <div class="panel panel-default">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('frontend.index') }}">
                        <i class="fa fa-home"></i> <strong>Home</strong>
                    </a>
                </li>
                <li>
                    <a href="{!! route('frontend.music.artists.index') !!}">
                        <strong>Artists</strong>
                    </a>
                </li>
                <li>
                    {!! $artist->name !!}
                </li>
            </ol> 
            <div class="panel-heading">
                <h1 class="h3 text-center"><strong>{!! $title !!}</strong></h1>
            </div>
            @if ($artist->bio || $artist->image)
            <div class="panel-body">
                <div class="caption" align="center">
                    @isset ($artist->image)
                        <img src="{{ $artist->image->getUrl('thumb') }}" 
                        alt="{{ $title }}" class="img-thumbnail">
                    @endisset
                    @isset($artist->bio)
                        <p>{!! $artist->bio !!}</p>
                    @endisset
                </div>
            </div><!--panel-body-->
            @endif
        </div><!--panel-->
    </div><!--col-xs-12-->

    @if (!$albums_count || !$singles_count)
        <div class="col-md-12">
            @if (!$albums_count)
                <div class="well">
                    <p class="lead text-center">No Albums Yet For <strong>{!! $artist->name !!}</strong></p>
                </div>
            @endif

            @if (!$singles_count)
                <div class="well">
                    <p class="lead text-center">No Singles Yet For <strong>{!! $artist->name !!}</strong></p>
                </div>
            @endif
        </div>
    @endif

    @if ($albums_count)
    <div class="{!! $singles_count ? 'col-md-6' : 'col-md-12' !!}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="level">
                    <h3 class="flex">Albums: <code>{!! $albums_count !!}</code></h3>

                    @if ($albums_count >= 5)
                       <a href="{!! route('frontend.music.artists.albums', $artist) !!}" 
                            class="btn btn-success btn-md">
                            <strong>View All...</strong>
                        </a> 
                    @endif
                </div>
            </div><!--panel-heading-->

            <div class="panel-body">
                @include('frontend.music.albums.list')
            </div><!--panel-body-->
        </div><!--panel-->
    </div><!--col-md-6-->
    @endif

    @if ($singles_count)
    <div class="{!! $albums_count ? 'col-md-6' : 'col-md-12' !!}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="level">
                    <h3 class="flex">Singles: <code>{!! $singles_count !!}</code></h3>

                    @if ($singles_count >= 5)
                        <div>
                           <a href="{!! route('frontend.music.artists.singles', $artist) !!}" 
                                class="btn btn-success btn-md">
                                View All...
                            </a> 
                        </div>
                    @endif
                </div>
            </div><!--panel-heading-->

            <div class="panel-body">
                @include('frontend.music.singles.list')
            </div><!--panel-body-->
        </div><!--panel-->
    </div><!--col-md-6-->
    @endif

    <div class="col-md-12">
        @if ($tracks_count)
        <div class="panel panel-default">
            <div class="panel-heading">    
                <div class="level">
                    <h3 class="flex">Contributed Tracks: <code>{!! $tracks_count !!}</code></h3>

                    @if ($tracks_count >= 5)
                        <div>
                           <a href="{{ 
                                    route('frontend.music.artists.tracks', $artist) 
                                }}" class="btn btn-success btn-md">
                                <strong>View All...</strong>
                            </a> 
                        </div>
                    @endif
                </div>
            </div><!--panel-heading-->

            <div class="panel-body">
                @include('frontend.music.tracks.list')
            </div><!--panel-body-->
        </div><!--panel-->
        @else
            <div class="well">
                <p class="lead text-center">
                    No Contributed Tracks Yet For <strong>{!! $artist->name !!}</strong>
                </p>
            </div>
        @endif
    </div><!--col-md-12-->

@endsection

@section('before-scripts')
    <script>
        var playlist = {!! $tracks !!}
    </script>
@endsection
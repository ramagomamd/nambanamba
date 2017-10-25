@extends('frontend.layouts.app')

@section('title', "{$title} - " . app_name())

@section('meta')
    {!! SEOMeta::generate(true) !!}
    {!! OpenGraph::generate(true) !!}
    {!! Twitter::generate(true) !!}
@endsection

@section('content')
    <div class="col-md-12">
        <div class="panel panel-default">
            <ol class="breadcrumb">
                <li>
                    <a href="{!! route('frontend.index') !!}">
                        <i class="fa fa-home"></i> <strong>Home</strong>
                    </a>
                </li>
                <li>
                    {!! $category->name !!}
                </li>
            </ol> 
            <div class="panel-heading">
                <h1 class="h3 text-center"><strong>{!! $title !!}</strong></h1>
            </div>

            @isset ($category->description)
            <div class="panel-body">
                {!! $category->description !!}
            </div>
            @endisset
            @if ($genres->isNotEmpty())        
                <ul class="list-group">  
                    @foreach ($genres as $genre)
                        <li class="list-group-item"><span class="fa fa-angle-double-right"></span>
                            &nbsp;
                            <a href="
                                {{ route('frontend.music.categories.genres', [$category, $genre]) }}">
                                <strong>{!! $genre->name !!} </strong>
                            </a>
                        </li>   
                    @endforeach
                </ul>
            @endif
        </div><!--panel-->
    </div><!--col-xs-12-->

    @if (!$albums_count || !$singles_count)
        <div class="col-md-12">
            @if (!$albums_count)
                <div class="well">
                    <p class="lead text-center">No Albums Yet For <strong>{!! $category->name !!}</strong></p>
                </div>
            @endif

            @if (!$singles_count)
                <div class="well">
                    <p class="lead text-center">No Singles Yet For <strong>{!! $category->name !!}</strong></p>
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
                       <a href="{!! route('frontend.music.categories.albums', $category) !!}" 
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
                           <a href="{!! route('frontend.music.categories.singles', $category) !!}" 
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

@endsection
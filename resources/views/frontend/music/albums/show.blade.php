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
                    <a href="{{ route('frontend.index') }}">
                        <i class="fa fa-home"></i> <strong>Home</strong>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.music.categories.show', $album->category) }}">
                        <strong>{!! $album->category->name !!}</strong>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.music.categories.genres', 
                            [$album->category, $album->genre]) }}">
                        <strong>{!! $album->genre->name !!}</strong>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.music.categories.genres.albums', 
                        [$album->category, $album->genre]) }}">
                        <strong>Albums</strong>
                    </a>
                </li>
                <li class="active">{!! $album->full_title !!}</li>
            </ol>
            <div class="panel-heading">
                <h1 class="h3 text-center"><strong>{!! $title !!}</strong></h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        @if (!is_null($album->cover))
                            <div align="center" style="margin-bottom: 1em">
                                <img src="{!! $album->cover->getUrl() !!}" alt="{!! $album->full_title !!}"
                                class="img-thumbnail">
                            </div>
                        @endif
                    </div> 
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <td><em>Title:</em></td>
                                <td>
                                    <strong>{!! $album->title !!}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td><em>Artist:</em></td>
                                <td>
                                    <strong>{!! $album->getArtistsLink('frontend') !!}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td><em>Category:</em></td>
                                <td>
                                    <a href="{{ route('frontend.music.categories.show', 
                                        $album->category) }}">
                                        <strong>{{ $album->category->name }}</strong>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><em>Genre:</em></td>
                                <td>
                                    <a href="{{ route('frontend.music.genres.show', 
                                        $album->genre) }}">
                                        <strong>{{ $album->genre->name }}</strong>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><em>Total Tracks:</em></td>
                                <td>
                                    <strong>{{ $album->tracks->count() }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td><em>Total PlayTime:</em></td>
                                <td>
                                    <strong>{{ $album->play_time }}</strong>
                                </td>
                            </tr>
                        </table>
                        @if (!is_null($album->zip))
                            <p>
                                <a href="{{ $album->zip->getUrl() }}" class="btn btn-success btn-lg btn-block">
                                    <span class="fa fa-download"> Full Zip Download</span>
                                </a>
                            </p>
                        @endif
                    </div> 
                     
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading with-border">
                <h4 class="box-title"><strong>Album Tracklist</strong></h4>
            </div>

            <div class="panel-body">
                @if ($album->tracks->isNotEmpty())
                    @include('frontend.music.tracks.list', ['tracks' => $album->tracks])
                @else
                    <p class="text-center lead">
                        {!! title_case("No tracks uploaded yet for  <strong>{$album->title}</strong>") !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('before-scripts')
    <script>
        var playlist = {!! $album->tracks !!}
    </script>
@endsection
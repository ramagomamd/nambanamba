@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.artists.management') .' - '. trans('labels.backend.music.artists.view'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.artists.management') }}
        <small>{{ $artist->name }}</small>
    </h1>
@endsection

@section('content')
<div id="app">
    <div class="box box-success">
        <div class="box-header">
            <ul class="nav nav-tabs">
                <li :class="{active: view}" @click.prevent="toggleView('view')">
                    <a href="#"><strong>View</strong></a>
                </li>
                <li :class="{active: edit}" @click.prevent="toggleView('edit')">
                    <a href="#"><strong>Edit</strong></a>
                </li>
                <li :class="{active: albums}" @click.prevent="toggleView('albums')">
                    <a href="#"><strong>Albums</strong></a>
                </li>
                <li :class="{active: singles}" @click.prevent="toggleView('singles')">
                        <a href="#"><strong>Singles</strong></a>
                </li>
                <li :class="{active: tracks}" @click.prevent="toggleView('tracks')">
                    <a href="#"><strong>Contributed Tracks</strong></a>
                </li>
            </ul>
            <div class="box-tools pull-right">
                <div class="mb-10 hidden-sm hidden-xs">
                    {{ link_to_route('admin.music.artists.index', trans('menus.backend.music.artists.all'), [], ['class' => 'btn btn-primary btn-xs']) }}
                    <button class="btn btn-success btn-xs" @click.prevent="toggleView('view')" :disabled="view">
                        {{ trans('menus.backend.music.artists.view') }}
                    </button>
                    <button class="btn btn-warning btn-xs" @click.prevent="toggleView('edit')" :disabled="edit">
                        {{ trans('menus.backend.music.artists.edit') }}
                    </button>
                </div><!--pull right-->
            </div><!--box-tools-->
        </div>

        <div class="caption" align="center">
           @isset ($artist->image)
                <img src="{{ $artist->image->getUrl('thumb') }}" alt="{{ $title }}" class="img-thumbnail">
            @endisset
            <div class="caption">
                <h3>{{ $title }}</h3>
                <p>
                    {!! $artist->delete_action !!}
                </p>
            </div>
            <hr>
        </div>
    </div>
    
      
    <div v-show="edit">
        <div class="box box-info">
            @include('backend.music.artists.edit')
        </div>
    </div>
        
    <div v-if="albums">
        @if ($albums->isNotEmpty())
        <div class="box box-info">
            <div class="box-body">
                <div class="col-xs-12">
                    <div class="box-header with-border">
                        <h4><strong>
                            Artist
                            @if ($albums->count() == 1)
                                {{ str_singular(trans('labels.backend.music.artists.albums')) }}
                            @else
                                {{ trans('labels.backend.music.artists.albums') }}
                            @endif
                            <br>Total: {{ $albums_count }}
                        </strong></h4>
                    </div>
                        
                    <div class="list-group" 
                        style="margin-left: 10px; margin-right: 10px; margin-top: 10px">
                        @include('backend.music.albums.list')
                        <div class="clearfix"></div>
                    </div>
                    @if ($albums->count() >= 5)
                    <div align="center"> 
                        <a href="{{ route('admin.music.artists.albums', $artist) }}" 
                            class="btn btn-info btn-lg" style="margin-top: 20px; margin-bottom: 20px">
                            {{ 'All ' . $title . ' Albums' }}
                        </a>
                    </div>
                    @endif
                </div><!-- col-xs-12 -->
            </div>
        </div>
        @else
            <p class="lead">No Albums Yet For <strong>{!! $artist->name !!}</strong></p>
        @endif
    </div>

        
    <div v-if="singles">
        @if ($singles->isNotEmpty())
        <div class="box box-info">
            <div class="box-body">
                <div class="col-xs-12">
                    <div class="box-header with-border">
                        <h4><strong>
                            Artist 
                            @if ($singles->count() == 1)
                                {{ str_singular(trans('labels.backend.music.artists.singles')) }}
                            @else
                                {{ trans('labels.backend.music.artists.singles') }}              
                            @endif
                            <br>Total: {{ $singles_count }}
                        </strong></h4>
                    </div>
                        
                    <div class="list-group" style="margin-left: 10px; margin-right: 10px; margin-top: 10px">
                        @include('backend.music.singles.list')
                    </div>
                    @if ($singles->count() >= 5)
                        <div align="center"> 
                            <a href="{{ route('admin.music.artists.singles', $artist) }}"
                                class="btn btn-info btn-lg" style="margin-top: 20px; margin-bottom: 20px"> 
                                {{ 'All ' . $title . ' Singles' }}
                            </a>
                        </div>
                    @endif
                </div><!-- col-xs-12 -->
            </div>
        </div>
        @else
            <p class="lead">No Singles Yet For <strong>{!! $artist->name !!}</strong></p>
        @endif
    </div>

    <div v-if="tracks">
        @if ($tracks->isNotEmpty())
        <div class="box box-info">
            <div class="box-body">
                <div class="col-xs-12">
                    <div class="box-header with-border">
                        <h4><strong>
                            Artist Contributed
                            @if ($tracks->count() == 1)
                                {{ str_singular(trans('labels.backend.music.artists.tracks')) }}
                            @else
                                {{ trans('labels.backend.music.artists.tracks') }}              
                            @endif
                            <br>Total: {{ $tracks_count }}
                        </strong></h4>
                    </div>
                        
                    <div class="list-group" style="margin-left: 10px; margin-right: 10px; margin-top: 10px">
                        @include('backend.music.tracks.list')
                    </div>
                    @if ($tracks->count() >= 5)
                        <div align="center"> 
                            <a href="{{ route('admin.music.artists.tracks', $artist) }}"
                                class="btn btn-info btn-lg" style="margin-top: 20px; margin-bottom: 20px"> 
                                {{ 'All ' . $title . ' Tracks' }}
                            </a>
                        </div>
                    @endif
                </div><!-- col-xs-12 -->
            </div>
        </div>
        @else
            <p class="lead">No Tracks Yet For <strong>{!! $artist->name !!}</strong></p>
        @endif
    </div>

    <div v-show="view">
        <div class="box box-info">
            <div class="box-body">
                <div class="caption">
                    <h4><strong>Artist Info</strong></h4><br>
                </div>
                <table class="table">
                    <tr>
                        <tr>
                            @isset ($artist->name)
                            <td><em>Name:</em></td>
                            <td>
                                <strong>{!! $artist->name !!}</strong>
                            </td>
                            @endisset
                        </tr>
                    </tr>
                    <tr>
                        @isset ($artist->slug)
                        <td><p><em>Slug:</em> </td>
                        <td>
                            <strong>{!! $artist->slug !!}</strong>
                        </td>
                        @endisset
                    </tr>
                    <tr>
                        @isset ($artist->bio)
                        <td><p><em>Bio:</em> </td>
                        <td>
                            <strong>{!! $artist->bio !!}</strong>
                        </td>
                        @endisset
                    </tr>
                </table>
            </div>
            <div class="box-footer">
                <p>Created: <em>{{ $artist->created_at->diffForHumans() }}</em></p>
                <p>Edited: <em>{{ $artist->updated_at->diffForHumans() }}</em></p>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

@endsection

@section('after-scripts')
    <script src="{{ asset('js/backend/music/artist.js') }}"></script>
@endsection
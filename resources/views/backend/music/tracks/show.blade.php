@extends ('backend.layouts.app')

@section ('title', $title)

@section('page-header')
    <h1> {!! $title !!} </h1>
@endsection

@section('content')
<div id="app">
    <div class="box box-success">
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.music.categories.show', 
                            $track->trackable->category) }}">
                    {{ $track->trackable->category->name }}
                </a>
            </li>
            <li>
                <a href="{{ route('admin.music.categories.genres', 
                        [$track->trackable->category, $track->trackable->genre]) }}">
                    {{ $track->trackable->genre->name }}
                </a>
            </li>
            @if ($track->trackable_type == 'albums')
                <li>
                    <a href="{{ route('admin.music.categories.genres.albums', 
                        [$track->trackable->category, $track->trackable->genre]) }}">
                        Albums
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.music.albums.show', 
                        [$track->trackable->category, $track->trackable->genre, $track->trackable]) 
                    }}">
                        {{ $track->trackable->full_title }}
                    </a>
                </li>
            @elseif ($track->trackable_type == 'singles')
                <li>
                    <a href="{{ route('admin.music.categories.genres.singles', 
                        [$track->trackable->category, $track->trackable->genre]) }}">
                        Singles
                    </a>
                </li>
            @endif
            <li class="active">{{ $track->full_title }}</li>
        </ol>
        
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                <div class="mb-10 hidden-sm hidden-xs">
                    {{ link_to_route('admin.music.tracks.index', trans('menus.backend.music.tracks.all'), [], ['class' => 'btn btn-primary btn-xs']) }}
                    <button class="btn btn-success btn-xs" @click="toggleView" :disabled="view">
                        {{ trans('menus.backend.music.tracks.view') }}
                    </button>
                    <button class="btn btn-warning btn-xs" @click="toggleView" :disabled="edit">
                        {{ trans('menus.backend.music.tracks.edit') }}
                    </button>
                </div><!--pull right-->
            </div><br><!--box-tools-->
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="caption" align="center">
            @if ($track->cover)
                <img src="{{ $track->cover->getUrl() }}" alt="{{ $track->title }}" class="img-thumbnail">
            @endif
            <hr>
            </div>
            <div v-if="view">
                @if ($track->file)
                    <div align="center" style="margin-bottom: 1em">
                        <audio src="{{ $track->url }}" controls>
                            Download <a href="{{ $track->url }}">{{ $track->title }}</a>
                        </audio>
                        <br>
                        <a href="{{ route('admin.music.tracks.refresh-cache', $track) }}" class="btn btn-warning">
                            <span class="fa fa-eraser"> Refresh Cache</span>
                        </a>
                    </div>       
                @endif
                <table class="table">
                    @isset($track->artists)
                    <tr>
                        <td><em>Artists:</em></td>
                        <td>
                            <strong>{!! $track->getArtistsLink() !!}</strong>
                        </td>
                    </tr>
                    @endisset
                    @isset($track->title)
                    <tr>
                        <td><em>Title:</em></td>
                        <td>
                            <strong>{{ $track->title }}</strong>
                        </td>
                    </tr>
                    @endisset
                    @isset($track->year)
                    <tr>
                        <td><em>Year:</em></td>
                        <td><strong>{{ $track->year }}</strong></td>
                    </tr>
                    @endisset
                    @isset($track->number)
                    <tr>
                        <td><em>Track #:</em></td>
                        <td><strong>{{ $track->number }}</strong></td>
                    </tr>
                    @endisset
                    @isset($track->album_artist)
                    <tr>
                        <td><em>Album Artist:</em></td>
                        <td><strong>{!! $track->getAlbumArtistLink() !!}</strong></td>
                    </tr>
                    @endisset
                    {!! $track->belongs !!}
                    <tr>
                        <td>
                            <em>
                                {{ str_singular(trans('labels.backend.music.tracks.genres')) }}
                            </em>
                        </td>
                        <td>
                            <a href="{{ route('admin.music.genres.show', 
                                $track->trackable->genre) }}">
                                <strong>{{ $track->trackable->genre->name }}</strong>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><p>
                            <em>
                                {{ str_singular(trans('labels.backend.music.categories.owner')) }}
                            </em>
                            </p></td>
                        <td>
                            <a href="{{ route('admin.music.categories.show', 
                                $track->trackable->category) }}">
                                <strong>{{ $track->trackable->category->name }}</strong>
                            </a>
                        </td>
                    </tr>
                    @isset($track->producer)
                    <tr>
                        <td><em>Producer: </em></td>
                        <td><strong>{!! $track->getProducerLink() !!}</strong></td>
                    </tr>
                    @endisset
                    @isset($track->bitrate)
                    <tr>
                        <td><em>Bitrate: </em></td>
                        <td><strong>{{ $track->bitrate }}</strong></td>
                    </tr>
                    @endisset
                    @isset($track->duration)
                    <tr>
                        <td><em>Duration: </em></td>
                        <td><strong>{{ $track->duration }}</strong></td>
                    </tr>
                    @endisset
                    @isset($track->copyright)
                    <tr>
                        <td><em>Copyright: </em></td>
                        <td><strong>{{ $track->copyright }}</strong></td>
                    </tr>
                    @endisset
                    @isset($track->comment)
                    <tr>
                        <td><em>Comment: </em></td>
                        <td><strong>{{ $track->comment }}</strong></td>
                    </tr>
                    @endisset
                </table>
                <div align="center" style="margin-bottom: 15px">
                {{ Form::open(['route' => ['admin.music.tracks.download', $track], 
                                'method' => 'post']) }}
                    <input type="submit" name="download" value="Download" 
                            class="btn btn-success btn-lg">
                {{ Form::close() }}
                </div>
        
                <div class="panel-footer">
                    <p>Created: <em>{{ $track->created_at->diffForHumans() }}</em></p>
                    <p>Edited: <em>{{ $track->updated_at->diffForHumans() }}</em></p>
                </div>
            </div>
            <div v-if="edit">
                @include('backend.music.tracks.edit')
            </div>
            
        </div><!-- /.box-body -->
    </div>
</div>
@endsection

@section('after-scripts')
    <script src="{{ asset('js/backend/music/track.js') }}"></script>
@endsection
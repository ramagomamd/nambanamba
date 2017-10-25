@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.albums.management') .' - '. trans('labels.backend.music.albums.view'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.albums.management') }}
    </h1>
@endsection


@section('content')

<div id="app">
    <div class="box box-success">
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.music.categories.show', $album->category) }}">
                    {!! $album->category->name !!}
                </a>
            </li>
            <li>
                <a href="{{ route('admin.music.categories.genres', 
                        [$album->category, $album->genre]) }}">
                    {!! $album->genre->name !!}
                </a>
            </li>
            <li>
                <a href="{{ route('admin.music.categories.genres.albums', 
                    [$album->category, $album->genre]) }}">
                    Albums
                </a>
            </li>
            <li class="active">{!! $album->full_title !!}</li>
        </ol>

        <div class="box-header">
            <ul class="nav nav-tabs">
                <li :class="{active: tabs.tracksList}" @click.prevent="toggleTabs('tracksList')">
                    <a href="#"><strong><i class="fa fa-list"></i> Tracks List</strong></a>
                </li>
                <li :class="{active: tabs.info}" @click.prevent="toggleTabs('info')">
                    <a href="#"><strong><i class="fa fa-info"></i> Info</strong></a>
                </li>
                <li :class="{active: tabs.upload }" @click.prevent="toggleTabs('upload')">
                    <a href="#"><strong><i class="fa fa-upload"></i> Upload</strong></a>
                </li>
                <li :class="{active: tabs.edit }" @click.prevent="toggleTabs('edit')">
                    <a href="#"><strong><i class="fa fa-edit"></i> Edit</strong></a>
                </li>
            </ul>
            <div class="box-tools pull-right" style="margin-right: 7px">
                <div class="btn-group">
                    <a href="{{ route('admin.music.albums.index') }}" class="btn btn-primary btn-md">
                        <i class="fa fa-folder-open" data-toggle="tooltip" data-placement="top" 
                            title="{{ trans('buttons.general.crud.list') }}"></i> {{ trans('menus.backend.music.albums.all') }}
                    </a>
                    <a href="{{ route('admin.music.albums.refresh-cache', $album) }}" class="btn btn-warning">
                        <span class="fa fa-eraser"> Refresh Cache</span>
                    </a>
                    @if ($tracks->count() > 1)
                        <a href="{!! route('admin.music.albums.generate-zip', $album) !!}" class="btn btn-success">
                            {!! isset($album->zip) ? "Regenerate Zip Archive" : "Generate Album Zip" !!}
                        </a>
                    @endif
                    {!! $album->delete_action !!}
                    @isset ($album->zip)
                        <a href="{{ $album->zip->getUrl() }}" class="btn btn-primary">
                            <span class="fa fa-download"> Full Zip Download</span>
                        </a>
                    @endisset
                </div>
            </div>
        </div><!-- /.box-header -->

        <div class="box-body" align="center">
            <h3><strong>{!! $album->full_title !!}</strong></h3>
        </div>  
    </div>

    <div v-if="tabs.upload" class="row">
        <div class="col-md-12">
            <album-upload></album-upload>
        <div class="clearfix"></div>
        </div>
    </div><!-- /.row -->

    <div v-if="tabs.edit">
        @include('backend.music.albums.edit')
    </div>

    <div v-if="tabs.tracksList" class="box box-info">
        <div class="box-header with-border">
            <h4 class="box-title"><strong>Album Tracklist</strong></h4>
        </div>

        <div class="box-body">
            <div class="row">
                @if ($tracks->isNotEmpty())
                    <div class="col-md-12" align="center">
                        <div class="table-responsive">
                            @include('backend.music.albums.tracks')
                            <div class="pull-right" style="margin-right: 45px"> {{ $tracks->links() }} </div>
                        </div><!--table-responsive-->
                    </div>
                @else
                    <p class="text-center">Upload Album Tracks Above</p>
                @endif
            </div>
        </div>
    </div>

    <div v-if="tabs.info" class="box box-success">
        <div class="box-header with-border">
            <h4 class="box-title"><strong>Album Info</strong></h4>
        </div>

        <div class="panel-body">
            <div class="caption" align="center">
                @isset ($album->cover)
                    <img src="{{ $album->cover->getUrl() }}" alt="{{ $album->full_title }}" 
                        class="img-thumbnail" style="margin-bottom: 1em">
                @endisset
                <form method="POST" enctype="multipart/form-data">
                    <br><image-upload name="cover" style="margin-bottom: 1em" @loaded="onLoad"></image-upload>
                </form>
            </div>
            <br>
            <table class="table">
                <tr>
                    <tr>
                        <td><em>Artists:</em></td>
                        <td>
                            <strong>{!! $album->getArtistsLink() !!}</strong>
                        </td>
                    </tr>
                </tr>
                <tr>
                    <td><p><em>Title:</em> </td>
                    <td>
                        <strong>{{ $album->title }}</strong>
                    </td>
                </tr>
                <tr>
                    <td><p><em>Slug:</em> </td>
                    <td>
                        <strong>{{ $album->slug }}</strong>
                    </td>
                </tr>
                <tr>
                    <td><p><em>Category:</em> </td>
                    <td>
                        <strong>
                            <a href="{!! route('admin.music.categories.show', $album->category) !!}">
                                {!! $album->category->name !!}
                            </a>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td><p><em>Genre:</em> </td>
                    <td>
                        <strong>
                            <a href="{!! route('admin.music.genres.show', $album->genre) !!}">
                                {!! $album->genre->name !!}
                            </a>
                        </strong>
                    </td>
                </tr>
                @if ($album->description)
                <tr>
                    <td><p><em>Description:</em> </td>
                    <td>
                        <strong>{{ $album->description }}</strong>
                    </td>
                </tr>
                @endif
                @if ($album->genres)
                <tr>
                    <td><p>
                        <em>
                            {{ str_singular(trans('labels.backend.music.genres.owner')) }}
                        </em>
                    </p></td>
                    <td>
                        <a href="{!! route('admin.music.genres.show', $album->genre) !!}">
                            <strong>{!! $album->genre->name !!}</strong>
                        </a>
                    </td>
                </tr>
                @endif
                @if ($album->categories)
                <tr>
                    <td><p>
                            <em>
                                {{ str_singular(trans('labels.backend.music.categories.owner')) }}
                            </em>
                        </p>
                    </td>
                    <td>
                        <a href="{!! route('admin.music.categories.show', $album->category) !!}">
                            <strong>{!! $album->category->name !!}</strong>
                        </a>
                    </td>
                </tr>
                @endif
            </table>

            <div class="panel-footer">
                <p>Created: <em>{{ $album->created_at->diffForHumans() }}</em></p>
                <p>Edited: <em>{{ $album->updated_at->diffForHumans() }}</em></p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('after-scripts')
    <script>
        var url = "{!! route('admin.music.albums.upload') !!}"
        var storeCoverUrl = "{!! route('admin.music.albums.upload-cover') !!}"
        var albumId = "{!! $album->id !!}"
    </script>
    <script src="{{ asset('js/backend/music/album.js') }}"></script>
@endsection
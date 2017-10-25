@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.categories.management') .' - '. trans('labels.backend.music.categories.view'))

@section('after-styles')
    {{ Html::style(asset('css/vendor/vue-multiselect/vue-multiselect.min.css')) }}
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.categories.management') }}
        <small>{{ $category->name }}</small>
    </h1>
@endsection

@section('content')
<div id="app">
    <div class="box box-success">
        <div class="box-header">
            <ul class="nav nav-tabs">
                <li :class="{active: tabs.genres}" @click.prevent="toggleTabs('genres')">
                    <a href="#"><strong><i class="fa fa-archive"></i> Genres</strong></a>
                </li>
                <li :class="{active: tabs.details}" @click.prevent="toggleTabs('details')">
                    <a href="#"><strong><i class="fa fa-info"></i> Details</strong></a>
                </li>
                <li :class="{active: tabs.edit}" @click.prevent="toggleTabs('edit')">
                    <a href="#"><strong><i class="fa fa-edit"></i> Edit</strong></a>
                </li>
                <li :class="{active: tabs.albums}" @click.prevent="toggleTabs('albums')">
                    <a href="#"><strong><i class="fa fa-folder-open"></i> Albums</strong></a>
                </li>
                <li :class="{active: tabs.singles}" @click.prevent="toggleTabs('singles')">
                        <a href="#"><strong><i class="fa fa-folder-open-o"></i> Singles</strong></a>
                </li>
            </ul>
            <div class="box-tools pull-right">
                <div class="mb-10 hidden-sm hidden-xs">
                    {{ link_to_route('admin.music.categories.index', trans('menus.backend.music.categories.all'), [], ['class' => 'btn btn-primary btn-xs']) }}
                    <button class="btn btn-success btn-xs" @click.prevent="toggleTabs('details')" 
                        :disabled="tabs.details">
                        {{ trans('menus.backend.music.categories.view') }}
                    </button>
                    <button class="btn btn-warning btn-xs" @click.prevent="toggleTabs('edit')" 
                        :disabled="tabs.edit">
                        {{ trans('menus.backend.music.categories.edit') }}
                    </button>
                </div><!--pull right-->
            </div><!--box-tools-->
        </div>

        <div class="caption" align="center">
            <div class="caption">
                <h3>{{ $title }}</h3>
                <p>
                    {!! $category->delete_action !!}
                </p>
            </div>
            <hr>
        </div>
    </div>
    
    <div v-if="tabs.genres">
        @if ($category->genres->isNotEmpty())
        <div class="box box-info">  
                <div class="box-header">
                    <h4><strong>
                        Category
                        @if ($category->genres->count() == 1)
                            {{ str_singular(trans('labels.backend.music.genres.owner')) }}
                        @else
                            {{ trans('labels.backend.music.genres.owner') }}
                        @endif
                    </strong></h4>
                </div>           
                <ul class="list-group">  
                    @foreach ($category->genres as $genre)
                        <li class="list-group-item"><span class="fa fa-angle-double-right"></span>&nbsp;
                            <a href="{{ route('admin.music.categories.genres', [$category, $genre]) }}">
                                <strong>{!! $genre->name !!} </strong>
                            </a>
                        </li>   
                    @endforeach
                </ul>
        </div>
        @else
            <p class="lead">No Genres Yet For <strong>{!! $category->name !!}</strong></p>
        @endif
    </div>

    <div v-if="tabs.details" class="box box-info">
        <div class="box-body">
            <div class="caption">
                <h4><strong>Category Info</strong></h4><br>
            </div>
            <table class="table">
                <tr>
                    <tr>
                        @isset ($category->name)
                        <td><em>Name:</em></td>
                        <td>
                            <strong>{!! $category->name !!}</strong>
                        </td>
                        @endisset
                    </tr>
                </tr>
                <tr>
                    @isset ($category->slug)
                    <td><p><em>Slug:</em> </td>
                    <td>
                        <strong>{!! $category->slug !!}</strong>
                    </td>
                    @endisset
                </tr>
                <tr>
                    @isset ($category->description)
                    <td><p><em>Description:</em> </td>
                    <td>
                        <strong>{!! $category->description !!}</strong>
                    </td>
                    @endisset
                </tr>
            </table>
        </div>
        <div class="box-footer">
            <p>Created: <em>{{ $category->created_at->diffForHumans() }}</em></p>
            <p>Edited: <em>{{ $category->updated_at->diffForHumans() }}</em></p>
        </div>
    </div>
      
    <div v-if="tabs.edit">
        <div class="box box-info">
            @include('backend.music.categories.edit')
        </div>
    </div>

    <div v-if="tabs.albums">
        @if ($albums->isNotEmpty())
        <div class="box box-info">
            <div class="box-body">
                <div class="col-xs-12">
                    <div class="box-header with-border">
                        <h4><strong>
                            Genre
                            @if ($albums->count() == 1)
                                {{ str_singular(trans('labels.backend.music.albums.owner')) }}
                            @else
                                {{ trans('labels.backend.music.albums.owner') }}
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
                        <a href="{{ $moreAlbums }}" class="btn btn-info btn-lg" 
                            style="margin-top: 20px; margin-bottom: 20px">
                            {{ 'All ' . $title . ' Albums' }}
                        </a>
                    </div>
                    @endif
                </div><!-- col-xs-12 -->
            </div>
        </div>
        @else
            <p class="lead">No Albums Yet For <strong>{!! $category->name !!}</strong></p>
        @endif
    </div>

    <div v-if="tabs.singles">
            @if ($singles->isNotEmpty())
            <div class="box box-info">
                <div class="box-body">
                    <div class="col-xs-12">
                        <div class="box-header with-border">
                            <h4><strong>
                                @if ($singles->count() == 1)
                                    {{ str_singular(trans('labels.backend.music.singles.owner')) }}
                                @else
                                    {{ trans('labels.backend.music.singles.owner') }}
                                @endif
                            </strong></h4>
                        </div>
                            
                        <div class="list-group" 
                            style="margin-left: 10px; margin-right: 10px; margin-top: 10px">
                            @include('backend.music.singles.list')
                            <div class="clearfix"></div>
                        </div>
                        @if ($singles_count > 5)
                        <div align="center"> 
                            <a href="{{ $moreSingles }}" class="btn btn-info btn-lg" 
                                style="margin-top: 20px; margin-bottom: 20px">
                                {!! 'All ' . $category->name . ' Singles' !!}
                            </a>
                        </div>
                        @endif
                    </div><!-- col-xs-12 -->
                </div>
            </div>
            @else
                <p class="lead">No Singles Yet For <strong>{!! $category->name !!}</strong></p>
            @endif
        </div>
    </div>
</div>

@endsection

@section('after-scripts')
    <script>$('.btn').button()</script>
    <script src="{{ asset('js/backend/music/category.js') }}"></script>
@endsection
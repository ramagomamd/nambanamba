@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.artists.management'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.artists.management') }}
    </h1>
@endsection

@section('content')
    <div id="app">
    	<div class="box box-success">
            <div class="box-header with-border">
                <h3 v-show="all" class="box-title">{{ $title }}</h3>
                <h3 v-show="add" class="box-title">{{ trans('labels.backend.music.artists.create') }}</h3> 

                <div class="box-tools">
                    <div class="pull-right mb-10 hidden-sm hidden-xs">
                        <button class="btn btn-primary btn-xs" @click="toggleIndex" :disabled="all">
                            {{ trans('menus.backend.music.artists.all') }}
                        </button>
                        <button class="btn btn-success btn-xs" @click="toggleIndex" :disabled="add">
                            {{ trans('menus.backend.music.artists.create') }}
                        </button>
                    </div><!--pull right-->
                </div><!--box-tools-->
            </div><!-- /.box-header -->

            <div class="box-body" v-show="all">
                @if ($artists->isNotEmpty())
                    <div class="table-responsive"> 
                        @include('backend.music.artists.list')
                        {{ $artists->links() }}              
                    </div><!--table-responsive-->
                @else
                <p class="lead">No Artists Yet</p>
                @endif
            </div><!-- /.box-body -->  
            <div v-show="add">
                @include('backend.music.artists.create')
            </div>
            
        </div>
    </div>
@endsection

@section('after-scripts')
    <script src="{{ asset('js/backend/music/artist.js') }}"></script>
@endsection
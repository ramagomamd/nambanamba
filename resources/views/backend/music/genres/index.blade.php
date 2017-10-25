@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.genres.management') . ' - ' .trans('labels.backend.music.genres.all'))

@section('after-styles')
    {{ Html::style(asset('css/vendor/vue-multiselect/vue-multiselect.min.css')) }}
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.genres.management') }}
        <small>{{ trans('labels.backend.music.genres.all') }}</small>
    </h1>
@endsection

@section('content')
<div id="app">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 v-show="all" class="box-title">{{ $title }}</h3>
            <h3 v-show="add" class="box-title">{{ trans('labels.backend.music.genres.create') }}</h3> 

            <div class="box-tools">
                <div class="pull-right mb-10 hidden-sm hidden-xs">
                    <button class="btn btn-primary btn-xs" @click="toggleIndex" :disabled="all">
                        {{ trans('menus.backend.music.genres.all') }}
                    </button>
                    <button class="btn btn-success btn-xs" @click="toggleIndex" :disabled="add">
                        {{ trans('menus.backend.music.genres.create') }}
                    </button>
                    <a class="btn btn-warning btn-xs" href="{!! route('admin.music.genres.refresh-cache') !!}">
                        Refresh Genres Cache
                    </a>
                </div><!--pull right-->
            </div><!--box-tools-->
        </div><!-- /.box-header -->

        <div class="box-body" v-show="all">
            @if ($genres->count() > 0)
                <div class="table-responsive">
                    @include('backend.music.genres.list')
                    {{ $genres->links() }}
                </div><!--table-responsive-->
            @else
            <p class="lead">No Genres Yet</p>
            @endif
        </div><!-- /.box-body -->
        <div v-show="add">
            @include('backend.music.genres.create')
        </div>
    </div>
</div>
@endsection

@section('before-scripts')
    <script>
        var page = "create"
    </script>
@endsection

@section('after-scripts')
    <script src="{{ asset('js/backend/music/genre.js') }}"></script>
@endsection
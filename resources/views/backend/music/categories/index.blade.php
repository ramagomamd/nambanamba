@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.categories.management') . ' - ' .trans('labels.backend.music.categories.all'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.categories.management') }}
        <small>{{ trans('labels.backend.music.categories.all') }}</small>
    </h1>
@endsection

@section('content')
<div id="app">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 v-show="all" class="box-title">{{ $title }}</h3>
            <h3 v-show="add" class="box-title">
                {{ trans('labels.backend.music.categories.create') }}
            </h3> 

            <div class="box-tools">
                <div class="pull-right mb-10 hidden-sm hidden-xs">
                    <button class="btn btn-primary btn-xs" @click="toggleIndex" :disabled="all">
                        View All
                    </button>
                    <button class="btn btn-success btn-xs" @click="toggleIndex" :disabled="add">
                        Create New
                    </button>
                    <a class="btn btn-warning btn-xs" href="{!! route('admin.music.categories.refresh-cache') !!}">
                        Refresh Categories Cache
                    </a>
                </div><!--pull right-->
            </div><!--box-tools-->
        </div><!-- /.box-header -->

        <div class="box-body" v-show="all">
            @if ($categories->count() > 0)
                <div class="table-responsive">
                    @include('backend.music.categories.list')
                    {{ $categories->links() }}
                </div><!--table-responsive-->
            @else
            <p class="lead">No Categories Yet</p>
            @endif
        </div><!-- /.box-body -->
        <div v-show="add">
            @include('backend.music.categories.create')
        </div>
    </div>
</div>
@endsection

@section('after-scripts')
    <script src="{{ asset('js/backend/music/category.js') }}"></script>
@endsection
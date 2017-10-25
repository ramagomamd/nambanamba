@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.singles.management') .' - '. $title)

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.singles.management') }}
        <small>{{ $title }}</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>

            <div class="box-tools">
                <div class="pull-right mb-10 hidden-sm hidden-xs">
                    <a class="btn btn-warning btn-xs" href="{!! route('admin.music.categories.clear-cache') !!}">
                        Clear Cache
                    </a>
                    <a href="{!! route('admin.music.crawl.singles') !!}" class="btn btn-success btn-xs">
                        Crawl Singles
                    </a>
                </div><!--pull right-->
            </div><!--box-tools-->
        </div><!-- /.box-header -->

        <div class="box-body">
            @if ($singles->isNotEmpty())
                <div class="table-responsive">
                    @include('backend.music.singles.list')           
                    {!! $singles->links() !!}
                </div>
            @else
            <p class="lead">No Singles Yet</p>
            @endif
        </div><!-- /.box-body -->
    </div>
@endsection
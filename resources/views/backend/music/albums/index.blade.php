@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.albums.management'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.albums.management') }}
    </h1>
@endsection

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $title }}</h3>

        <div class="box-tools">
            <div class="pull-right mb-10 hidden-sm hidden-xs">
                <a class="btn btn-warning btn-xs" href="{!! route('admin.music.albums.refresh-cache') !!}">
                    Refresh Albums Cache
                </a>
                <a href="{!! route('admin.music.crawl.albums') !!}" class="btn btn-success btn-xs">
                    Crawl Albums
                </a>
            </div><!--pull right-->
        </div><!--box-tools-->
    </div><!-- /.box-header -->

    <div class="box-body">
    	@if ($albums->isNotEmpty())
            <div class="table-responsive"> 
            	@include('backend.music.albums.list')
            	{!! $albums->links() !!}           
            </div><!--table-responsive-->
        @else
            <div>
            	<p class="lead">No Albums Yet</p>
            </div>
        @endif
    </div><!-- /.box-body -->  
</div>
@endsection
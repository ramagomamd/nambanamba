@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.music.tracks.management'))

@section('after-styles')
    
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.music.tracks.management') }}
    </h1>
@endsection

@section('content')

<div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>

            <div class="box-tools pull-right">
                @include('backend.music.partials.track-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            @if ($tracks->isNotEmpty())
                <div class="table-responsive">
                    @include('backend.music.tracks.list')           
                    {{ $tracks->links() }}
                </div>
            @else
            <p class="lead">No Tracks Yet</p>
            @endif
        </div><!-- /.box-body -->
</div>

@endsection
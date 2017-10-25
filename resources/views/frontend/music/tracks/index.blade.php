@extends('frontend.layouts.app')

@section('title', "{$title} - " . app_name())

@section('meta')
	{!! SEOMeta::generate(true) !!}
	{!! OpenGraph::generate(true) !!}
	{!! Twitter::generate(true) !!}
@endsection

@section('content')
    <div class="col-xs-12">
		<div class="panel panel-default">
			<ol class="breadcrumb">
				<li>
				    <a href="{{ route('frontend.index') }}">
				        <i class="fa fa-home"></i> <strong>Home</strong>
				    </a>
				</li>
				@isset($artist)
					<li>
					    <a href="{{ route('frontend.music.artists.index') }}">
					        <strong>Artists</strong>
					    </a>
					</li>
					<li>
					    <a href="{{ route('frontend.music.artists.show', $artist) }}">
					        <strong>{!! $artist->name !!}</strong>
					    </a>
					</li>
				@endisset
				<li>
					Tracks
				</li>
			</ol>
			<div class="panel-heading">
                <h1 class="h3 text-center"><strong>{!! $title !!}</strong></h1>
            </div>
			<div class="panel-body">
				{!! $tracks->links() !!}
				@include('frontend.music.tracks.list')
				{!! $tracks->links() !!}
			</div>
		</div>
	</div>
@endsection

@section('before-scripts')
    <script>
        var playlist = {!! json_encode($tracks->toArray()['data']) !!}
    </script>
@endsection
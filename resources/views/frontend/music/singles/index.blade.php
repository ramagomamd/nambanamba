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
				@isset($category)
					<li>
					    <a href="{{ route('frontend.music.categories.show', $category) }}">
					        <strong>{!! $category->name !!}</strong>
					    </a>
					</li>
				@endisset
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
				@if(isset($genre) && !isset($category))
					<li>
					    <a href="{{ route('frontend.music.genres.index') }}">
					        <strong>Genres</strong>
					    </a>
					</li>
					<li>
					    <a href="{{ route('frontend.music.genres.show', $genre) }}">
					        <strong>{!! $genre->name !!}</strong>
					    </a>
					</li>
				@endif
				@if(isset($category) && isset($genre))
					<li>
					    <a href="{{ route('frontend.music.categories.genres', 
                                    [$category, $genre]) }}">
					        <strong>{!! $genre->name !!}</strong>
					    </a>
					</li>
				@endif
				<li>
					Singles
				</li>
			</ol>
			<div class="panel-heading">
                <h1 class="h3 text-center"><strong>{!! $title !!}</strong></h1>
            </div>
			<div class="panel-body">
				{!! $singles->links() !!}
				@include('frontend.music.singles.list')
				{!! $singles->links() !!}
			</div>
		</div>
	</div>
@endsection
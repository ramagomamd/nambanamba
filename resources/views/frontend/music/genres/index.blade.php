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
	                <a href="{!! route('frontend.index') !!}">
	                    <i class="fa fa-home"></i> <strong>Home</strong>
	                </a>
	            </li>
	            <li>
	                Genres
	            </li>
	        </ol>
			<div class="panel-heading">
                <h1 class="h3 text-center"><strong>{!! $title !!}</strong></h1>
            </div>
			<div class="panel-body">
				<ul>
					@forelse ($genres as $genre)
						<li>
							<a href="{!! route('frontend.music.genres.show', $genre) !!}">
								{!! $genre->name !!}
							</a>
						</li>
					@empty
						<div class="well">
							<p class="lead text-center">No Genres Yet</p>
						</div>
					@endforelse	
				</ul>
			</div>
		</div>
	</div>
@endsection
@extends('frontend.layouts.app')

@section('title', "{$title} - " . app_name())

@section('content')
    <div class="col-xs-12">
		<div class="panel panel-default">
			<ol class="breadcrumb">
				<li>
				    <a href="{{ route('frontend.index') }}">
				        <i class="fa fa-home"></i> <strong>Home</strong>
				    </a>
				</li>
				<li>
					Artists
				</li>
			</ol>
			<div class="panel-heading">
                <h1 class="h3 text-center"><strong>{!! $title !!}</strong></h1>
            </div>

			<div class="panel-body">
				{!! $artists->links() !!}
				@include('frontend.music.artists.list')
				{!! $artists->links() !!}
			</div>
		</div>
	</div>
@endsection
@if ($albums->isNotEmpty())
	@foreach ($albums as $album)
			<div class="media">
				<a class="pull-left" href="#">
					@if (isset($album->cover))
					<img class="media-object img-thumbnail" src="{!! $album->cover->getUrl('thumb') !!}" 
						alt="{!! $album->full_title !!}">
					@else
						<span class="img-thumbnail">No Cover</span>
					@endif
				</a>
				<div class="media-body">
					<h4 class="h5 media-heading">
						<strong>
							<a href="{!! route('frontend.music.albums.show', 
								[$album->category, $album->genre, $album]) !!}">
								{!! $album->full_title !!}
							</a>
						</strong>
					</h4>
					<p>
						<a href="{!! route('frontend.music.categories.show', $album->category) !!}">
							<em>{!! $album->category->name !!}</em>
						</a> <i class="fa fa-exchange"></i>
						<a href="{!! route('frontend.music.genres.show', $album->genre) !!}">
							<em>{!! $album->genre->name !!}</em>
						</a>
					</p>
					<p>{!! $album->play_time !!}</p>
				</div>
			</div> 
		@if (!$loop->last)
			<hr>
		@endif
	@endforeach

@else
	<div class="well">
		<p class="lead text-center">No Albums Yet</p>
	</div>
@endif
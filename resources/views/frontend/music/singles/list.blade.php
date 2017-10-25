@if ($singles->isNotEmpty())
	@foreach ($singles as $single)
		<div class="media">
			<a class="pull-left" href="#">
				@if ($single->track->cover)
				<img class="media-object img-thumbnail" src="{!! $single->track->cover->getUrl('thumb') !!}" 
					alt="{!! $single->track->full_title !!}">
				@else
					 No Cover
				@endif
			</a>
			<div class="media-body">
				<h4 class="h5 media-heading">
					<strong>
						<a href="{!! route('frontend.music.tracks.show', 
							[$single->track->trackable->category, $single->track->trackable->genre, $single->track->trackable_type, $single->track->trackable, $single->track]) !!}">
							{!! $single->track->full_title !!}
						</a>
					</strong>
				</h4>
				<p>
					<a href="{!! route('frontend.music.categories.show', $single->track->trackable->category) !!}">
						<em>{!! $single->track->trackable->category->name !!}</em>
					</a> <i class="fa fa-exchange"></i>
					<a href="{!! route('frontend.music.genres.show', $single->track->trackable->genre) !!}">
						<em>{!! $single->track->trackable->genre->name !!}</em>
					</a>
				</p>
				<p>{!! $single->track->duration !!}</p>
			</div> 
		</div> 
		@if (!$loop->last)
			<hr>
		@endif
	@endforeach
@else
	<div class="well">
		<p class="lead text-center">No Singles Yet</p>
	</div>
@endif
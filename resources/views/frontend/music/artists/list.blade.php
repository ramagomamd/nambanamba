
@if ($artists->isNotEmpty())
	@foreach ($artists->chunk(2) as $chunk)
		<div class="row">
			@foreach ($chunk as $artist)
				<div class="col-md-6">
					<div class="media" style="margin-bottom: 2em">
						<a class="pull-left" href="#">
							@if (isset($artist->image))
							<img class="img-thumbnail media-object" src="{!! $artist->image->getUrl('thumb') !!}" 
								alt="{!! $artist->full_title !!}" 
								height="75px" width="75px">
							@else
								No Image
							@endif
						</a>
						<div class="media-body">
							<h4 class="media-heading">
								<strong>
									<a href="{!! route('frontend.music.artists.show',$artist) !!}">
										{!! $artist->name !!}
									</a>
								</strong>
							</h4>
							<p>
								{!! $artist->albums_count ?: 'No' !!} 
								{!!$artist->albums_count > 1 ? str_plural('Album') : 'Album' !!}  
									<i class="fa fa-exchange"></i> 
								{!! $artist->singles_count ?: 'No' !!} 
								{!!$artist->singles_count > 1 ? str_plural('Single') : 'Single' !!}
							</p>
							<p>
								{!! $artist->tracks_count ?: 'No' !!} 
								Contributed {!!$artist->tracks_count > 1 ? str_plural('Track') : 'Track' !!}
							</p>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	@endforeach
@else
	<div class="well">
		<p class="lead text-center">No Artists Yet</p>
	</div>
@endif
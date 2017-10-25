@if ($tracks->isNotEmpty())
<player inline-template v-cloak>
	<div>
		<div class="player" style="margin: 2em">
	      <div class="track-info">
	        <span class="track-title">
	          @{{ title || "So quiet in here... Lets play somethin'" }}
	        </span>
	      </div>
	      <div v-if="playing" class="time-controls">
	        <span class="current-duration">
	          @{{ timer }}
	        </span>
	        <span class="player-controls">
	          <a @click.prevent="repeat = !repeat" class="fa fa-retweet" :class="{active: !repeat}"></a>
	        </span>
	        <span class="total-duration">
	          @{{ duration }}
	        </span>
	      </div>
	      <div class="player-footer">
	        <div class="player-bar">
	          <div class="progress"  ref="progress"></div>
	        </div>
	        <div class="song-controls">
	          <a  v-if="playlist.length > 1" @click.prevent="skip('prev')" class="prev-track">
	            <i class="fa fa-step-backward"></i>
	          </a>
	          <a v-else class="next-track" style="cursor: default;">
	            <i class="fa fa-headphones"></i>
	          </a>
	          <a v-if="!playing" @click.prevent="play" class="play">
	            <i class="fa fa-play"></i>
	          </a>
	          <a v-else @click.prevent="pause" class="pause">
	            <i class="fa fa-pause"></i>
	          </a>
	          <a v-if="playlist.length > 1" @click.prevent="skip('next')" class="next-track">
	            <i class="fa fa-step-forward"></i>
	          </a>
	          <a v-else class="next-track" style="cursor: default;">
	            <i class="fa fa-headphones"></i>
	          </a>
	        </div>
	      </div>
	    </div>
		@foreach ($tracks->chunk(2) as $chunk)
			<div class="row">
				@foreach ($chunk as $track)
					<div class="col-md-6">
						<div class="media" style="margin-bottom: 2em 0em">
							<a class="pull-left" href="#">
								@if (isset($track->cover))
								<img class="img-thumbnail media-object" src="{!! $track->cover->getUrl('thumb') !!}" alt="{!! $track->full_title !!}">
								@else
									No Cover
								@endif
							</a>
							<div class="media-body">
								<h4 class="media-heading">
									<button v-if="index === {!! $track->index !!} && playing"
										class="btn btn-danger" @click.prevent="pause">
										<span class="fa fa-pause-circle" style="font-size: 2em"></span>
									</button>
									<button v-else class="btn btn-info" 
										@click.prevent="skipTo({!! $track->index !!})">
										<span class="fa fa-play-circle" style="font-size: 2em"></span>
									</button>
									<strong>
										<a href="{!! route('frontend.music.tracks.show', 
											[$track->trackable->category, $track->trackable->genre, $track->trackable_type, $track->trackable, $track]) !!}">
											{!! $track->title !!}
										</a>
									</strong>
								</h4>
								<p>{!! $track->getArtistsLink('frontend') !!}</p>
								<p>{!! $track->duration !!} <i class="fa fa-exchange"></i> {!! $track->size !!}</p>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		@endforeach
	</div>
</player>
@else
	<div class="well">
		<p class="lead text-center">No Tracks Yet</p>
	</div>
@endif
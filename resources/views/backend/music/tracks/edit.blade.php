@section('after-styles')
    {{ Html::style(asset('css/vendor/vue-multiselect/vue-multiselect.min.css')) }}
@endsection

{{ Form::model($track, ['route' => ['admin.music.tracks.update', $track], 'class' => 'form-horizontal', 
'role' => 'form', 'method' => 'PATCH', 'files' => true]) }}

    <div class="row">
        <div class="col-md-11">
            <div class="box-body">
                <div class="form-group">
                    <label for="cover" class="col-lg-2 control-label">
                        @if(!$track->cover)
                            {{ trans('validation.attributes.backend.music.tracks.cover') }}:
                        @else
                            {{ trans('validation.attributes.backend.music.tracks.cover_change') }}:
                        @endif
                    </label>

                    <div class="col-lg-6">
                        <input type="file" name="cover" data-vv-as="Track Cover" 
                            v-validate="'image|size:15000'">
                        <span class="text-danger" v-if="errors.has('cover')" v-text="errors.first('cover')">
                        </span>
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label for="main_artist" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.artists.owner') }}:
                    </label>

                    <div class="col-lg-10 control">
                        <multiselect v-model="track.artists" tag-placeholder="Add an Artist" 
                            placeholder="Search or add an artist" :max="5" :allow-empty="false" 
                            class="form-control" :hide-selected="true" style="width: 97.5%" @tag="addArtist"
                            :options="artists" :show-labels="true" :multiple="true" :taggable="true">
                        </multiselect>
                        <input type="hidden" name="main" :value="track.artists">
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label for="features" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.artists.feature') }}:
                    </label>

                    <div class="col-lg-10 control">
                        <multiselect v-model="track.features" tag-placeholder="Add a Featured Artist" 
                            placeholder="Search or add a featured Artist" :max="5" @tag="addFeature"
                            class="form-control" :hide-selected="true" style="width: 97.5%" 
                            :options="artists" :show-labels="true" :multiple="true" :taggable="true">
                        </multiselect>
                        <input type="hidden" name="features" :value="track.features">
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label for="producer" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.artists.producer') }}:
                    </label>

                    <div class="col-lg-10 control">
                        <multiselect v-model="track.producer" tag-placeholder="Add Track Producer" 
                            placeholder="Search or add Track Producer" :max="5" @tag="addProducer"
                            class="form-control" :hide-selected="true" style="width: 97.5%" 
                            :options="artists" :show-labels="true" :taggable="true">
                        </multiselect>
                        <input type="hidden" name="producer" :value="track.producer">
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label for="title" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.albums.title') }}:
                    </label>

                    <div class="col-lg-10">
                        <input type="text" name="title" class="form-control" data-vv-as="Track Title"
                            v-validate="'required|min:2|max:190'" value="{{ $track->title }}"
                            placeholder="{{ trans('validation.attributes.backend.music.albums.title') }}">
                        <span class="text-danger" v-if="errors.has('title')" 
                            v-text="errors.first('title')">
                        </span>
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label for="year" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.tracks.year') }}:
                    </label>

                    <div class="col-lg-10">
                        {{ Form::text('year', null, ['class' => 'form-control', 'maxlength' => '191', 'placeholder' => trans('validation.attributes.backend.music.tracks.year')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label for="number" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.tracks.number') }}:
                    </label>

                    <div class="col-lg-10">
                        {{ Form::text('number', null, ['class' => 'form-control', 'maxlength' => '191', 'placeholder' => trans('validation.attributes.backend.music.tracks.number')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label for="number" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.tracks.copyright') }}:
                    </label>

                    <div class="col-lg-10">
                        {{ Form::text('copyright', null, ['class' => 'form-control', 'maxlength' => '191', 'placeholder' => trans('validation.attributes.backend.music.tracks.copyright')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label for="comment" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.tracks.comment') }}:
                    </label>

                    <div class="col-lg-10">
                        <textarea rows="4" cols="50" name="comment" maxlength="500"
                            class="form-control" data-vv-as="Track Comment" v-validate="'min:2|max:190'"
                            placeholder="{{ trans('validation.attributes.backend.music.tracks.comment') }}">{!! $track->comment !!}
                        </textarea>
                        <span class="text-danger" v-if="errors.has('comment')" 
                            v-text="errors.first('comment')">
                        </span>
                    </div><!--col-lg-10-->
                </div><!--form control-->
            </div>
        </div>

        <div class="col-md-12">
            <div class="box-footer with-border">
                <div class="pull-left">
                    <button class="btn btn-danger btn-md" @click.prevent="toggleView">
                        <i class="fa fa-close" data-toggle="tooltip" data-placement="top" 
                            title="{{ trans('buttons.general.cancel') }}">
                        </i>
                        {{ trans('buttons.general.cancel') }}
                    </button>
                </div><!--pull-left-->

                <div class="pull-right">
                    <button class="btn btn-success btn-md" 
                        :disabled="errors.any() || isFormInvalid">
                        <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" 
                            title="{{ trans('buttons.general.crud.edit') }}">
                        </i> 
                        {{ trans('buttons.general.crud.edit') }}
                    </button>
                </div><!--pull-right-->
                <div class="clearfix"></div>
            </div> 
        </div>
    </div>

{{ Form::close() }}

@section('before-scripts')
    <script>
        var getTrackArtists = {!! $track->all_artists !!}
        var getTrackFeatures = {!! $track->all_features !!}
        var getTrackProducer = "{!! $track->producer !!}"
    </script>
@endsection
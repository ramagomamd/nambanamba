@section('after-styles')
    {{ Html::style(asset('css/vendor/vue-multiselect/vue-multiselect.min.css')) }}
@endsection
{{ Form::model($album, ['route' => ['admin.music.albums.update', $album], 'class' => 'form-horizontal', 
    'role' => 'form', 'method' => 'PATCH', 'files' => true]) }}   

    <div class="box box-success">
        <div class="box-header with-border">
            <h4 class="box-title">
                <strong>{!! trans('labels.backend.music.albums.edit') !!}</strong>
            </h4>
        </div><!-- /.box-header --> 

        <div class="box-body">
            <div class="col-md-11">
                
                <div class="form-group">
                    <label for="artists" class="col-lg-2 control-label">
                        Artists:
                    </label>

                    <div class="col-lg-10" style="padding-bottom: 1em">
                        <multiselect v-model="album.artists" tag-placeholder="Add this an artist" 
                            class="form-control"
                            placeholder="Search or add a artist" :max="4" :allow-empty="false" 
                            :options="artists" :show-labels="true" :multiple="true" 
                            :taggable="true" @tag="addArtist"
                            :hide-selected="true" style="width: 97.5%" data-vv-as="Album Artists">
                        </multiselect>
                        <input type="hidden" name="artists" :value="album.artists">
                    </div><!--col-lg-10-->
                </div>

                <div class="form-group">
                    <label for="title" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.albums.title') }}:
                    </label>

                    <div class="col-lg-10">
                        <input type="text" name="title" class="form-control" data-vv-as="Album Title"
                            v-validate="'required|min:2|max:190'" value="{{ $album->title }}"
                            placeholder="{{ trans('validation.attributes.backend.music.albums.title') }}">
                        <span class="text-danger" v-if="errors.has('title')" 
                            v-text="errors.first('title')">
                        </span>
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label for="categories" class="col-lg-2 control-label">
                        {{ str_singular(trans('validation.attributes.backend.music.categories.owner')) }}:
                    </label>
                    <div class="col-lg-10" style="display: inline-block;">
                        <select name="category" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{!! $category->name !!}"
                                {{ ($category->id == $album->category->id) ? "selected": "" }}>
                                {!! $category->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="genres" class="col-lg-2 control-label">
                        {{ str_singular(trans('validation.attributes.backend.music.genres.owner')) }}:
                    </label>
                    <div class="col-lg-10" style="display: inline-block;">
                        <select name="genre" class="form-control">
                            @foreach ($genres as $genre)
                                <option value="{!! $genre->name !!}"
                                {{ ($genre->id == $album->genre->id) ? "selected": "" }}>
                                {!! $genre->name !!}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.albums.description') }}:
                    </label>

                    <div class="col-lg-10">
                        <textarea rows="4" cols="50" name="description" maxlength="500"
                            class="form-control" data-vv-as="Album Description" v-validate="'min:2|max:190'"
                            placeholder="{{ trans('validation.attributes.backend.music.albums.description') }}">{!! $album->description !!}
                        </textarea>
                        <span class="text-danger" v-if="errors.has('description')" 
                            v-text="errors.first('description')">
                        </span>
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label for="type" class="col-lg-2 control-label">
                        Type:
                    </label>

                    <div class="col-lg-10">
                        <div class="checkbox">
                            <label class="btn btn-primary" 
                                style="padding: 1em; margin-right: 1em">
                                <input name="type" type="radio" value="album" 
                                {!! $album->type == 'album' ? "checked" : "" !!}> 
                                Album   
                            </label>
                            <label class="btn btn-primary" 
                                style="padding: 1em; margin-right: 1em">
                                <input name="type" type="radio" value="mixtape" 
                                {!! $album->type == 'mixtape' ? "checked" : "" !!}> 
                                MixTape   
                            </label>
                            <label class="btn btn-primary" 
                                style="padding: 1em; margin-right: 1em">
                                <input name="type" type="radio" value="ep" 
                                {!! $album->type == 'ep' ? "checked" : "" !!}> 
                                EP   
                            </label>
                        </div>
                    </div><!--col-lg-10-->
                </div><!--form control-->

            </div><!--/.box-body-->
        </div>
      
        <div class="box-footer with-border">
            <div class="col-md-12">
                <div class="pull-left">
                    <button class="btn btn-danger btn-md" @click.prevent="toggleTabs('tracksList')">
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
        var artists = {!! $album->artists !!}
    </script>
@endsection
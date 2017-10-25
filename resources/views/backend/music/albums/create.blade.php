@section('after-styles')
    {{ Html::style(asset('css/vendor/vue-multiselect/vue-multiselect.min.css')) }}
@endsection

{{ Form::open(['route' => 'admin.music.albums.store', 'class' => 'form-horizontal', 'role' => 'form', 
    'method' => 'post', 'files' => true]) }}

    <div class="row">
        <div class="col-md-11">

            <div class="clearfix" style="padding-top: 15px"></div>
            <div class="form-group">
                <label for="cover" class="col-lg-2 control-label">
                    {{ trans('validation.attributes.backend.music.albums.cover') }}:
                </label>

                <div class="col-lg-6">
                    <input type="file" name="cover" data-vv-as="Album Cover" 
                        v-validate="'image|size:15000'">
                    <span class="text-danger" v-if="errors.has('cover')" v-text="errors.first('cover')">
                    </span>
                </div><!--col-lg-10-->
            </div><!--form control-->
                        
            <div class="form-group">
                <label for="artist" class="col-lg-2 control-label">
                    {{ trans('validation.attributes.backend.music.artists.owner') }}:
                </label>

                <div class="col-lg-10 control" style="display: inline-block;">
                    <multiselect v-model="artists" tag-placeholder="Add an Artist" 
                        placeholder="Search or add an artist" :max="5" :allow-empty="false" 
                        class="form-control" :hide-selected="true" style="width: 97.5%" @tag="addArtist"
                        :options="allArtists" :show-labels="true" :multiple="true" :taggable="true">
                    </multiselect>
                    <input type="hidden" name="artists" :value="artists">
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                <label for="title" class="col-lg-2 control-label">
                    {{ trans('validation.attributes.backend.music.albums.title') }}:
                </label>

                <div class="col-lg-10">
                    <input type="text" name="title" class="form-control" data-vv-as="Album Title"
                        v-validate="'required|min:2|max:190'"
                        placeholder="{{ trans('validation.attributes.backend.music.albums.title') }}">
                    <span class="text-danger" v-if="errors.has('title')" 
                        v-text="errors.first('title')">
                    </span>
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                <label for="category" class="col-lg-2 control-label">
                    {{ trans('validation.attributes.backend.music.categories.owner') }}:
                </label>
                <div class="col-lg-10" style="display: inline-block;">
                    <multiselect v-model="category" tag-placeholder="Add this as new category" 
                        placeholder="Search or add a category" :max="5" :allow-empty="false" class="form-control" 
                        :options="categories" :show-labels="true" :taggable="true" @tag="addCategory" 
                        :hide-selected="true" style="width: 97.5%">
                    </multiselect>
                    <input type="hidden" name="category" :value="category">
                </div>
            </div>

            <div class="form-group">
                <label for="genres" class="col-lg-2 control-label">
                    {{ str_plural(trans('validation.attributes.backend.music.genres.owner')) }}:
                </label>
                <div class="col-lg-10" style="display: inline-block;">
                    <multiselect v-model="genres" tag-placeholder="Add this as new genre" 
                        class="form-control" 
                        placeholder="Search or add a genre" :max="4" :allow-empty="false" 
                        :options="allGenres" :show-labels="true" :multiple="true" 
                        :taggable="true" @tag="addGenre"
                        :hide-selected="true" style="width: 97.5%" data-vv-as="Album Main Category">
                    </multiselect>
                    <input type="hidden" name="genres" :value="genres">
                </div>
            </div>

           <div class="form-group" v-if="genres.length">
                <label for="genre" class="col-lg-2 control-label">
                    {{ trans('validation.attributes.backend.music.genres.main') }}:
                </label>

                <div class="col-lg-2" v-for="genre in genres">
                     <div class="btn btn-primary btn-xs">
                         <input type="radio" class="radio-inline" :value="genre" name="genre" checked> 
                         <label for="genre">@{{ genre }}</label>
                     </div>
                </div> <!--col-lg-2-->
            </div><!--form control-->
                        
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">
                    {{ trans('validation.attributes.backend.music.albums.description') }}:
                </label>

                <div class="col-lg-10">
                    <textarea rows="4" cols="50" name="description" maxlength="500"
                        class="form-control" data-vv-as="Album Description" v-validate="'min:2|max:190'"
                        placeholder="{{ trans('validation.attributes.backend.music.albums.description') }}">
                    </textarea>
                    <span class="text-danger" v-if="errors.has('description')" 
                        v-text="errors.first('description')">
                    </span>
                </div><!--col-lg-10-->
            </div><!--form control-->
        </div>
        
        <div class="col-md-12">
            <div class="box-footer with-border">
                <div class="pull-left">
                    <button class="btn btn-danger btn-md" @click.prevent="toggleIndex">
                        <i class="fa fa-close" data-toggle="tooltip" data-placement="top" 
                            title="{{ trans('buttons.general.cancel') }}">
                        </i>
                        {{ trans('buttons.general.cancel') }}
                    </button>
                </div><!--pull-left-->

                <div class="pull-right">
                    <button class="btn btn-success btn-md" 
                        :disabled="errors.any() || ! isFormDirty || isFormInvalid">
                        <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" 
                            title="{{ trans('buttons.general.crud.create') }}">
                        </i> 
                        {{ trans('buttons.general.crud.create') }}
                    </button>
                </div><!--pull-right-->
                <div class="clearfix"></div>
            </div> 
        </div>
    </div>

{{ Form::close() }}
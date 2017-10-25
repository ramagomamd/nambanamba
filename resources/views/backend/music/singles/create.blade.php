@section('after-styles')
    {{ Html::style(asset('css/vendor/vue-multiselect/vue-multiselect.min.css')) }}
@endsection

{{ Form::open(['route' => 'admin.music.singles.store', 'class' => 'form-horizontal', 'role' => 'form', 
    'id' => 'drop-tracks', 'method' => 'post', 'files' => true]) }}
<form method="POST" action="{{ route('admin.music.singles.store') }}" enctype="multipart/form-data" class="form-horizontal" 
    name="create-album" >
    <div v-if="upload" style="margin: 15px">
        <div class="col-md-12">
            <div class="pull-right box-tools" style="margin-right: 15px">
                <button class="btn btn-danger btn-sm" title="Remove" @click.prevent="upload = false">
                <i class="fa fa-times"></i></button>
            </div><!-- /. tools -->

            <single-upload :category="{!! $category->name !!}" :genre="{!! $genre->name !!}">
            </single-upload>

        <div class="clearfix"></div>
        </div>
    </div><!-- /.row -->
	<div v-else>
        <div class="col-md-11">

            <div class="box-body">

                <div class="form-group">
                    <label for="category" class="col-lg-2 control-label">
                        {{ str_plural(trans('validation.attributes.backend.music.categories.owner')) }}:
                    </label>
                    <div class="col-lg-10" style="display: inline-block;">
                        <multiselect v-model="category" tag-placeholder="Add this as new category" 
                            placeholder="Search or add a category" :max="5" :allow-empty="false" class="form-control" 
                            :options="categories" :show-labels="true" :taggable="true" @tag="addCategory" 
                            :hide-selected="true" style="width: 97.5%">
                        </multiselect>
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
                    </div>
                </div>

                <div class="form-group" v-if="genres.length">
                    <label for="genre" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.genres.main') }}:
                    </label>

                    <div class="col-lg-2" v-for="name in genres">
                         <div class="btn btn-primary btn-xs">
                             <input type="radio" class="radio-inline" v-model="genre" :value="name"> 
                             <label for="genre">@{{ name }}</label>
                         </div>
                    </div> <!--col-lg-2-->
                </div><!--form control-->

            </div> <!-- box-body -->
        </div><!-- col-lg-11 -->

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
                    <button class="btn btn-warning btn-md" 
                        :disabled="!checkUpload" @click.prevent="setUpload()">
                        <i class="fa fa-upload" data-toggle="tooltip" data-placement="top" 
                            title="{{ trans('buttons.general.crud.upload') }}">
                        </i> 
                        {{ trans('buttons.general.crud.upload') }}
                    </button>
                </div><!--pull-right-->
                <div class="clearfix"></div>
            </div><!-- /.box-footer -->
        </div><!--/.box-->

    </div><!-- /.row-->

{{ Form::close() }}

@section('before-scripts')
    <script>
        var page = "create";
        var url = "{!! route('admin.music.singles.store') !!}"
        var genres = {!! $genres !!}
        var categories = {!! $categories !!}
    </script>
@endsection
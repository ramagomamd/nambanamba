@extends ('backend.layouts.app')

@section ('title', 'Manage Music Uploads')

@section('page-header')
    <h1>
        Manage Music Uploads
        <small>{{ $title }}</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style(asset('css/vendor/vue-multiselect/vue-multiselect.min.css')) }}
@endsection

@section('content')
<div id="app">
    <div class="box box-success">
        <div class="box-header with-border">
            <ul class="nav nav-pills">
                <li :class="{active: albums.main}" @click.prevent="toggleMain('albums')">
                    <a href="#"><strong>Albums</strong></a>
                </li>
                <li :class="{active: singles.main}" @click.prevent="toggleMain('singles')">
                        <a href="#"><strong>Singles</strong></a>
                </li>
                <li :class="{active: crawl}" @click.prevent="toggleMain('crawl')">
                    <a href="#"><strong>Crawl</strong></a>
                </li>
            </ul>
            <div class="box-tools pull-right">
                <div class="mb-10 hidden-sm hidden-xs" style="margin: 1em">
                    <a href="{!! route('admin.music.categories.show', $category) !!}" 
                        class="btn btn-primary btn-md"><i class="fa fa-step-backward"></i> 
                        <strong>{!! $category->name . ' Category' !!}</strong> </a>
                </div><!--pull right-->
            </div><!--box-tools-->
        </div>

        <div class="caption" align="center">
            <div class="caption">
                <h3>{{ $title }} @{{ albums? 'Albums' : 'Singles' }}</h3>
                <div v-if="albums.main">
                    <div class="btn-group">
                        <button class="btn btn-success btn md" @click.prevent="toggleAlbum('create')" 
                            :disabled="albums.create"> Create An Album
                        </button>
                        <button class="btn btn-info btn md" @click.prevent="toggleAlbum('zip')" 
                            :disabled="albums.zip"> Upload Zip
                        </button>
                        <button class="btn btn-primary btn md" @click.prevent="toggleAlbum('remote')" 
                            :disabled="albums.remote"> Remote Upload
                        </button>
                    </div>
                    <br>Total  Albums: <code>{{ $albums_count }}</code>
                </div>
                <div v-if="singles.main">
                    <div class="btn-group">
                        <button class="btn btn-success btn md" @click.prevent="toggleSingle('upload')" 
                            :disabled="singles.upload"> Upload Singles
                        </button>
                        <button class="btn btn-primary btn md" @click.prevent="toggleSingle('remote')" 
                            :disabled="singles.remote"> Remote Upload
                        </button>
                    </div>
                    <br>Total  Singles: <code>{{ $singles_count }}</code>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div v-if="crawl" class="box box-info">
        <div class="box-body">
            <div class="box-header with-border">
                <h4><strong>
                    Crawl Sites
                </strong></h4>
            </div>

            <div class="clearfix" style="padding-top: 2em"></div>
            <form method="POST" action="{{ route('admin.music.crawl') }}" 
                class="form-horizontal" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="col-md-12">
                    <input type="hidden" name="category" value="{{ $category->name }}">
                    <input type="hidden" name="genre" value="{{ $genre->name }}">

                    <div class="form-group">
                        <label for="sites" class="col-lg-2 control-label">
                            Sites:
                        </label>
                        <div class="col-lg-10" style="display: inline-block;">
                            <select name="site" class="form-control">
                                <option value="lulamusic">Lulamusic</option>
                                <option value="slikour"> Slikour</option>
                                <option value="fakaza"> Fakaza</option>
                                <option value="songslover"> SongsLover</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="url" class="col-lg-2 control-label">URL</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="url">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pages" class="col-lg-2 control-label">Pages no.</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control" name="pages">
                        </div>
                    </div>

                    <div class="pull-left box-tools" style="margin-left: 15px">
                       <button class="btn btn-danger btn-sm" title="Remove" 
                           @click.prevent="toggleMain('albums')">
                       <i class="fa fa-times"></i> Cancel</button>
                   </div>
                   <div class="pull-right box-tools">
                       <button type="submit" class="btn btn-primary btn-md">Crawl</button>
                   </div>
                   
                </div>
            </form>
        </div>                  
    </div>
        
    <div v-if="albums.main">

        <div v-if="albums.remote" class="box box-info">
            <div class="box-body">
                <div class="box-header with-border">
                    <h4><strong>
                        Upload Album Via URL
                    </strong></h4>
                </div>

                <div class="clearfix" style="padding-top: 2em"></div>
                <form method="POST" action="{{ route('admin.music.albums.remote-upload') }}" 
                    class="form-horizontal" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="col-md-12">
                        <input type="hidden" name="category" value="{{ $category->name }}">
                        <input type="hidden" name="genre" value="{{ $genre->name }}">
                        <div class="form-group">
                            <label for="cover" class="col-lg-2 control-label">
                                Cover:
                            </label>

                            <div class="col-lg-6">
                                <input type="file" name="cover" data-vv-as="Album Cover" 
                                    v-validate="'image|size:15000'" accept="image/*">
                                <span class="text-danger" v-if="errors.has('cover')" v-text="errors.first('cover')">
                                </span>
                            </div><!--col-lg-10-->
                        </div><!--form control-->

                        <div class="form-group">
                            <label for="full_title" class="col-lg-2 control-label">
                                Full Title:
                            </label>

                            <div class="col-lg-10">
                                <input type="text" name="full_title" class="form-control" data-vv-as="Full Title"
                                    placeholder="Full Album Title" v-validate="'required|min:2'">
                                <span class="text-danger" v-if="errors.has('full_title')" 
                                    v-text="errors.first('full_title')">
                                </span>
                            </div><!--col-lg-10-->
                        </div><!--form control-->

                        <div class="form-group">
                            <label for="remote_link" class="col-lg-2 control-label">
                                URL:
                            </label>

                            <div class="col-lg-10">
                                <input type="text" name="remote_link" class="form-control" data-vv-as="Remote Link"
                                    placeholder="Upload Album Via URL" v-validate="'required'">
                                <span class="text-danger" v-if="errors.has('remote_link')" 
                                    v-text="errors.first('remote_link')">
                                </span>
                            </div><!--col-lg-10-->
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

                        <div class="form-group">
                            <label for="type" class="col-lg-2 control-label">
                                Type:
                            </label>

                            <div class="col-lg-10">
                                <div class="checkbox">
                                    <label class="btn btn-primary" 
                                        style="padding: 1em; margin-right: 1em">
                                        <input name="type" type="radio" value="album" checked> 
                                        Album   
                                    </label>
                                    <label class="btn btn-primary" 
                                        style="padding: 1em; margin-right: 1em">
                                        <input name="type" type="radio" value="mixtape" selected> 
                                        MixTape   
                                    </label>
                                    <label class="btn btn-primary" 
                                        style="padding: 1em; margin-right: 1em">
                                        <input name="type" type="radio" value="ep" selected> 
                                        EP   
                                    </label>
                                </div>
                            </div><!--col-lg-10-->
                        </div><!--form control-->

                        <div class="pull-right box-tools">
                            <button type="submit" class="btn btn-primary btn-md"
                                :disabled="errors.any() || ! isFormDirty || isFormInvalid">
                                <i class="fa fa-upload"></i> Upload
                            </button>
                        </div>

                        <div class="pull-left box-tools">
                           <button class="btn btn-danger btn-sm" title="Remove" 
                               @click.prevent="toggleAlbum('list')">
                               <i class="fa fa-times"></i> Cancel
                            </button>
                       </div>
                    </div>
                </form>
            </div>                  
        </div>

        <div v-if="albums.zip" class="box box-info">
            <div class="box-body">
                <div class="box-header with-border">
                    <h4><strong>
                        Upload Zipped Album
                    </strong></h4>
                </div>

                <div class="clearfix" style="padding-top: 2em"></div>
                <form method="POST" action="{{ route('admin.music.albums.upload-zip') }}" 
                    class="form-horizontal" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="col-md-12">
                        <input type="hidden" name="category" value="{{ $category->name }}">
                        <input type="hidden" name="genre" value="{{ $genre->name }}">
                        
                        <div class="form-group">
                            <label for="type" class="col-lg-2 control-label">
                                Zip File:
                            </label>

                            <div class="col-lg-10">
                                <input type="file" name="file">
                            </div><!--col-lg-10-->
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

                        <div class="form-group">
                            <label for="type" class="col-lg-2 control-label">
                                Type:
                            </label>

                            <div class="col-lg-10">
                                <div class="checkbox">
                                    <label class="btn btn-primary" 
                                        style="padding: 1em; margin-right: 1em">
                                        <input name="type" type="radio" value="album" checked> 
                                        Album   
                                    </label>
                                    <label class="btn btn-primary" 
                                        style="padding: 1em; margin-right: 1em">
                                        <input name="type" type="radio" value="mixtape" selected> 
                                        MixTape   
                                    </label>
                                    <label class="btn btn-primary" 
                                        style="padding: 1em; margin-right: 1em">
                                        <input name="type" type="radio" value="ep" selected> 
                                        EP   
                                    </label>
                                </div>
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                       <div class="pull-right box-tools">
                            <button type="submit" class="btn btn-primary btn-md"
                                :disabled="errors.any() || isFormInvalid">
                                <i class="fa fa-upload"></i> Upload
                            </button>
                        </div>

                        <div class="pull-left box-tools">
                           <button class="btn btn-danger btn-sm" title="Cancel" 
                               @click.prevent="toggleAlbum('list')">
                               <i class="fa fa-times"></i> Cancel
                            </button>
                       </div>
                    </div>
                </form>
            </div>                  
        </div>

        <div v-show="albums.list">
            @if ($albums->isNotEmpty())
            <div class="box box-info">
                <div class="box-body">
                    <div class="col-xs-12">
                        <div class="box-header with-border">
                            <h4><strong>
                                @if ($albums->count() == 1)
                                    {{ str_singular(trans('labels.backend.music.albums.owner')) }}
                                @else
                                    {{ trans('labels.backend.music.albums.owner') }}
                                @endif
                            </strong></h4>
                        </div>
                            
                        <div class="list-group" 
                            style="margin-left: 10px; margin-right: 10px; margin-top: 10px">
                            @include('backend.music.albums.list')
                            <div class="clearfix"></div>
                        </div>
                        @if ($albums_count > 5)
                        <div align="center"> 
                            <a href="{{ $moreAlbums }}" class="btn btn-info btn-lg" 
                                style="margin-top: 20px; margin-bottom: 20px">
                                {{ 'All ' . $title . ' Albums' }}
                            </a>
                        </div>
                        @endif
                    </div><!-- col-xs-12 -->
                </div>
            </div>
            @else
                <p class="lead">No Albums Yet For <strong>{!! $title !!}</strong></p>
            @endif
        </div>
        <div v-if="albums.create" class="box box-info">
            <div class="box-body">
                <div class="box-header with-border">
                    <h4><strong>
                        Create An Album
                    </strong></h4>
                </div>

                <div class="clearfix" style="padding-top: 2em"></div>
                    <form method="POST" action="{{ route('admin.music.albums.store') }}" class="form-horizontal">
                        {!! csrf_field() !!}
                        <div class="col-md-11">
                            <input type="hidden" name="category" value="{{ $category->name }}">
                            <input type="hidden" name="genre" value="{{ $genre->name }}">

                            <div class="form-group">
                                <label for="full_title" class="col-lg-2 control-label">
                                    Full Title:
                                </label>

                                <div class="col-lg-10">
                                    <input type="text" name="full_title" class="form-control" data-vv-as="Full Title"
                                        placeholder="Full Album Title" v-validate="'required|min:2'">
                                    <span class="text-danger" v-if="errors.has('full_title')" 
                                        v-text="errors.first('full_title')">
                                    </span>
                                </div><!--col-lg-10-->
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

                            <div class="form-group">
                                <label for="type" class="col-lg-2 control-label">
                                    Type:
                                </label>

                                <div class="col-lg-10">
                                    <div class="checkbox">
                                        <label class="btn btn-primary" 
                                            style="padding: 1em; margin-right: 1em">
                                            <input name="type" type="radio" value="album" checked> 
                                            Album   
                                        </label>
                                        <label class="btn btn-primary" 
                                            style="padding: 1em; margin-right: 1em">
                                            <input name="type" type="radio" value="mixtape" selected> 
                                            MixTape   
                                        </label>
                                        <label class="btn btn-primary" 
                                            style="padding: 1em; margin-right: 1em">
                                            <input name="type" type="radio" value="ep" selected> 
                                            EP   
                                        </label>
                                    </div>
                                </div><!--col-lg-10-->
                            </div><!--form control-->

                        </div>

                        <div class="col-md-12">
                            <div class="box-footer with-border">
                                <div class="pull-left">
                                    <button class="btn btn-danger btn-md" @click.prevent="toggleAlbum('list')">
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
                    </form>
                </div>                  
            </div>
        </div>

        <div v-if="singles.main">
            <div v-if="singles.remote" class="box box-info">
                <div class="box-body">
                    <div class="box-header with-border">
                        <h4><strong>
                            Upload Singles Via URL
                        </strong></h4>
                    </div>

                    <div class="clearfix" style="padding-top: 2em"></div>
                    <form method="POST" action="{{ route('admin.music.singles.remote-upload') }}" 
                        class="form-horizontal">
                        {!! csrf_field() !!}
                        <div class="col-md-12">
                            <input type="hidden" name="category" value="{{ $category->name }}">
                            <input type="hidden" name="genre" value="{{ $genre->name }}">
                            <div class="form-group">
                                    <label for="remote-links" class="col-lg-2 control-label">
                                        Comma  Seperated URL's:
                                    </label>

                                    <div class="col-lg-10">
                                        <textarea rows="4" cols="50" name="remote-links"
                                            class="form-control" v-validate="'min:2'"
                                            placeholder="Upload Singles Via URL">
                                        </textarea>
                                        <span class="text-danger" v-if="errors.has('remote-links')" 
                                            v-text="errors.first('remote-links')">
                                        </span>
                                    </div><!--col-lg-10-->
                                </div><!--form control-->
                            <div class="pull-right box-tools">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <i class="fa fa-upload"></i> Upload
                                </button>
                            </div>
                            
                            <div class="pull-left box-tools">
                               <button class="btn btn-danger btn-sm" title="Remove" 
                                   @click.prevent="toggleSingle('list')">
                                   <i class="fa fa-times"></i> Cancel
                                </button>
                           </div>
                        </div>
                    </form>
                </div>                  
            </div>
            <div v-show="singles.list">
                @if ($singles->isNotEmpty())
                <div class="box box-info">
                    <div class="box-body">
                        <div class="col-xs-12">
                            <div class="box-header with-border">
                                <h4><strong>
                                    @if ($singles->count() == 1)
                                        {{ str_singular(trans('labels.backend.music.singles.owner')) }}
                                    @else
                                        {{ trans('labels.backend.music.singles.owner') }}
                                    @endif
                                </strong></h4>
                            </div>
                                
                            <div class="list-group" 
                                style="margin-left: 10px; margin-right: 10px; margin-top: 10px">
                                @include('backend.music.singles.list')
                                <div class="clearfix"></div>
                            </div>
                            @if ($singles_count > 5)
                            <div align="center"> 
                                <a href="{{ $moreSingles }}" class="btn btn-info btn-lg" 
                                    style="margin-top: 20px; margin-bottom: 20px">
                                    {{ 'All ' . $title . ' Singles' }}
                                </a>
                            </div>
                            @endif
                        </div><!-- col-xs-12 -->
                    </div>
                </div>
                @else
                    <p class="lead">No Singles Yet For <strong>{!! $title !!}</strong></p>
                @endif
            </div>
            <div v-if="singles.upload">
                <div class="clearfix" style="padding-top: 2em"></div>
                <form method="POST" action="{{ route('admin.music.singles.store') }}" class="form-horizontal" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                        <input type="hidden" name="category" value="{{ $category->name }}">
                        <input type="hidden" name="genre" value="{{ $genre->name }}">
                        <!-- <input type="file" name="file"> <br> -->
                        <!-- <button type="submit" class="btn btn-default btn-md">Upload</button> -->
                        <div class="pull-right box-tools" style="margin-right: 15px">
                           <button class="btn btn-danger btn-sm" title="Remove" 
                               @click.prevent="toggleSingle('list')">
                           <i class="fa fa-times"></i></button>
                       </div>
                      <single-upload category="{!! $category->name !!}" 
                          genre="{!! $genre->name !!}">
                      </single-upload>
                </form>                 
            </div>
        </div>
    </div>

@endsection

@section('after-scripts')
    <script>
        var storeSingleUrl = "{!! route('admin.music.singles.store') !!}"
    </script>
    <script src="{{ asset('js/backend/music/general.js') }}"></script>
@endsection
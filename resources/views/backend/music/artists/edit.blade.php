{{ Form::model($artist, ['route' => ['admin.music.artists.update', $artist], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) }}
		
    <div class="box-header with-border">
        <h4><strong>{{ trans('labels.backend.music.artists.edit') }}</strong></h4>
    </div>
	<div class="row">
        <div class="col-xs-12"> 
            <div class="clearfix" style="padding-top: 15px"></div>
            <div class="form-group">
                <label for="image" class="col-lg-2 control-label">
                    {{ trans('validation.attributes.backend.music.artists.image') }}:
                </label>

                <div class="col-lg-6">
                    <input type="file" name="image" data-vv-as="Artist Image" 
                        v-validate="'image|size:15000'" accept="image/*">
                    <span class="text-danger" v-if="errors.has('image')" v-text="errors.first('image')">
                    </span>
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                <label for="name" class="col-lg-2 control-label">
                    {{ trans('validation.attributes.backend.music.artists.name') }}:
                </label>

                <div class="col-lg-10">
                    <input type="text" name="name" class="form-control" data-vv-as="Artist Name"
                        v-validate="'required|min:2|max:190'" value="{!! $artist->name !!}"
                        placeholder="{{ trans('validation.attributes.backend.music.artists.name') }}">
                    <span class="text-danger" v-if="errors.has('name')" 
                        v-text="errors.first('name')">
                    </span>
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                <label for="bio" class="col-lg-2 control-label">
                    {{ trans('validation.attributes.backend.music.artists.bio') }}:
                </label>

                <div class="col-lg-10">
                    <textarea rows="4" cols="50" name="bio" maxlength="500"
                        class="form-control" data-vv-as="Album Bio" v-validate="'min:2|max:190'"
                        placeholder="{{ trans('validation.attributes.backend.music.artists.bio') }}">{!! $artist->bio !!}
                    </textarea>
                    <span class="text-danger" v-if="errors.has('bio')" 
                        v-text="errors.first('bio')">
                    </span>
                </div><!--col-lg-10-->
            </div><!--form control-->

        </div>

		<div class="col-md-12">
            <div class="box-footer with-border">
                <div class="pull-left">
                    <button class="btn btn-danger btn-md" @click.prevent="toggleView('view')">
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
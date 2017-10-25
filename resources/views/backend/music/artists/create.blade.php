{{ Form::open(['route' => 'admin.music.artists.store', 'class' => 'form-horizontal', 'role' => 'form', 
    'method' => 'post', 'files' => true]) }}
		
	<div class="row">
        <div class="col-md-11">
            <div class="clearfix" style="padding-top: 15px"></div>

            <div class="form-group">
                <label for="image" class="col-lg-2 control-label">
                    {{ trans('validation.attributes.backend.music.artists.image') }}:
                </label>

                <div class="col-lg-6">
                    <input type="file" name="image" data-vv-as="Artist Image" 
                        v-validate="'image|size:15000'">
                    <span class="text-danger" v-if="errors.has('image')" v-text="errors.first('image')">
                    </span>
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                <label for="name" class="col-lg-2 control-label">
                    {{ trans('validation.attributes.backend.music.artists.name') }}:
                </label>

                <div class="col-lg-10">
                    <input type="text" name="name" class="form-control" data-vv-as="Album Title"
                        v-validate="'required|min:2|max:190'" autofocus
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
                        placeholder="{{ trans('validation.attributes.backend.music.artists.bio') }}">
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
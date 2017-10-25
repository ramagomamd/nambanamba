{{ Form::open(['route' => 'admin.music.categories.store', 'class' => 'form-horizontal', 'role' => 'form', 
    'method' => 'post']) }}

    <div class="row">
        <div class="col-md-11">
            <div class="clearfix" style="padding-top: 15px"></div>

            <div class="box-body">

                <div class="form-group">
                    <label for="name" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.categories.name') }}:
                    </label>

                    <div class="col-lg-10">
                        <input type="text" name="name" class="form-control" data-vv-as="Category Name"
                            v-validate="'required|min:2|max:190'" autofocus
                            placeholder="{{ trans('validation.attributes.backend.music.categories.name') }}">
                        <span class="text-danger" v-if="errors.has('name')" 
                            v-text="errors.first('name')">
                        </span>
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label for="description" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.categories.description') }}:
                    </label>

                    <div class="col-lg-10">
                        <textarea rows="4" cols="50" name="description" maxlength="500"
                            class="form-control" data-vv-as="Category Description" v-validate="'min:2|max:190'"
                            placeholder="{{ trans('validation.attributes.backend.music.categories.description') }}">
                        </textarea>
                        <span class="text-danger" v-if="errors.has('description')" 
                            v-text="errors.first('description')">
                        </span>
                    </div><!--col-lg-10-->
                </div><!--form control-->

                @if ($genres->isNotEmpty())
                <div class="form-group">
                    <label for="genres" class="col-lg-2 control-label">
                        {{ trans('validation.attributes.backend.music.genres.owner') }}:
                    </label>

                    <div class="col-lg-10">
                        <div class="checkbox">
                            @foreach ($genres as $genre)
                                <label class="btn btn-primary" style="padding: 1em; margin-right: 1em">
                                    <input name="genres[]" type="checkbox" value="{!! $genre->name !!}"> 
                                    {!! $genre->name !!}
                                </label>
                            @endforeach
                        </div>
                    </div><!--col-lg-10-->
                </div><!--form control-->
                @endif
            </div><!-- /.box-body -->
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
@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.settings.management'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.settings.management') }}
    </h1>
@endsection

@section('content')
	<div class="box box-success">   
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading"><strong><i class="fa fa-gear"></i> Settings</strong></div>
                <form action="{{ route('admin.settings.update') }}" method="POST" 
                    enctype="multipart/form-data">
                    {{ method_field("PUT") }}
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="list-group">
                            @foreach($settings as $setting)
                            <li class="list-group-item">
                                <h4 class="list-group-item-heading">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="fa fa-terminal"></span>
                                    <strong> {{ $setting->display_name }}</strong>
                                    <code>Music::setting('{{ $setting->key }}')</code>
                                    <div class="box-tools pull-left">

                                        <a href="{{ route('admin.settings.move_up', $setting) }}">
                                            <i class="fa fa-sort-up"></i>
                                        </a>&nbsp;
                                        <a href="{{ route('admin.settings.move_down', $setting) }}">
                                            <i class="fa fa-sort-down"></i>
                                        </a>&nbsp;
                                        <a href="{{ route('admin.settings.destroy', $setting) }}"
                                             data-method="delete"
                                             data-trans-button-cancel="{{ trans('buttons.general.cancel') }}"
                                             data-trans-button-confirm="{{ trans('buttons.general.crud.delete') }}"
                                             data-trans-title="{{ trans('strings.backend.general.are_you_sure') }}"
                                             class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="{{ trans('buttons.general.crud.delete') }}"></i>
                                        </a>  
                                    </div>
                                </h4>
                            </li>

                            <li class="list-group-item">
                                <p class="list-group-item-text">
                                    @if ($setting->type == "text")
                                        <div class="input-group">
                                            <span class="input-group-addon" class="close">
                                                <a href="{{ route('admin.settings.delete_value', $setting->id) }}"  
                                                    class="fa fa-close">
                                                </a>
                                            </span>
                                            <input type="text" class="form-control" name="{{ $setting->key }}" 
                                                value="{{ $setting->value }}">
                                        </div>
                                    @elseif($setting->type == "text_area")
                                        <div class="input-group">
                                            <span class="input-group-addon" class="close">
                                                <a href="{{ route('admin.settings.delete_value', $setting->id) }}" 
                                                    class="fa fa-close">
                                                </a>
                                            </span>
                                            <textarea class="form-control" name="{{ $setting->key }}">@if(isset($setting->value)){{ $setting->value }}@endif
                                            </textarea>
                                        </div>
                                    @elseif($setting->type == "image")
                                        @if ($setting->image)
                                            <div class="img_settings_container">
                                                <a href="{{ route('admin.settings.delete_value', $setting->id) }}" class="fa fa-close"></a>
                                                <img src="{{ $setting->image->getUrl() }}" style="width:200px; height:auto; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                            </div>
                                            <div class="clearfix"></div>
                                        @endif
                                        <input type="file" name="{{ $setting->key }}">
                                    @endif
                                </p>
                            </li> <br>
                            <button type="submit" class="btn btn-primary pull-right">Save Settings</button>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-12">

                <div style="clear:both"></div>

                <div class="panel" style="margin-top:10px;">
                    <div class="panel-heading">
                        <hr>
                        <h3 class="panel-title"><i class="fa fa-plus"></i> New Setting</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('admin.settings.store') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="col-md-4">
                                <label for="display_name">Name</label>
                                <input type="text" class="form-control" name="display_name" 
                                    value="{{ old('display_name') }}"
                                    placeholder="Setting name ex: Admin Title" required="required">
                            </div>
                            <div class="col-md-4">
                                <label for="key">Key</label>
                                <input type="text" class="form-control" name="key" value="{{ old('key') }}" 
                                    placeholder="Setting key ex: admin_title" required="required">
                            </div>
                            <div class="col-md-4">
                                <label for="type">Type</label>
                                <select name="type" class="form-control" required="required">
                                    <option value="">Choose type</option>
                                    <option value="text">Text Box</option>
                                    <option value="text_area">Text Area</option>
                                    <option value="image">Image</option>
                                </select>
                            </div>
                            
                            <div style="clear:both"></div> 
                            <button type="submit" class="btn btn-primary pull-right" style="margin: 15px">
                                <i class="music-plus"></i> Add New Setting
                            </button>
                            <div style="clear:both"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
    </div>

@endsection
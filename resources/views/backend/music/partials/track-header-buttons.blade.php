<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.music.tracks.index', 'Reload', [], ['class' => 'btn btn-primary btn-xs']) }}
    <a class="btn btn-warning btn-xs" href="{!! route('admin.music.tracks.refresh-cache') !!}">
        Refresh Tracks Cache
    </a>
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ trans('menus.backend.music.tracks.main') }} <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.music.tracks.index', 'Reload') }}</li>
            <li>
            	<a class="btn btn-warning btn-xs" href="{!! route('admin.music.tracks.refresh-cache') !!}">
                    Refresh Tracks Cache
                </a>
            </li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
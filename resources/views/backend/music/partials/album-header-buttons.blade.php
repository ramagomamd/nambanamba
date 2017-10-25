<div class="pull-right mb-10 hidden-sm hidden-xs">
    <button class="btn btn-primary btn-xs" @click="show = true" :disabled="show">
        {{ trans('menus.backend.music.albums.all') }}
    </button>
    <button class="btn btn-success btn-xs" @click="show = false" :disabled="!show">
        {{ trans('menus.backend.music.albums.create') }}
    </button>
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ trans('menus.backend.music.albums.main') }} <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.music.albums.index', trans('menus.backend.music.albums.all')) }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
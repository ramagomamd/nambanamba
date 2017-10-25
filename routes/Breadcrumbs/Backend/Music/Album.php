<?php

Breadcrumbs::register('admin.music.albums.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.music.albums.management'), route('admin.music.albums.index'));
});

Breadcrumbs::register('admin.music.albums.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.music.albums.index');
    $breadcrumbs->push(trans('menus.backend.music.albums.create'), route('admin.music.albums.create'));
});

Breadcrumbs::register('admin.music.albums.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.music.albums.index');
    $breadcrumbs->push(trans('menus.backend.music.albums.view'), route('admin.music.albums.show', $id));
});

Breadcrumbs::register('admin.music.albums.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.music.albums.index');
    $breadcrumbs->push(trans('menus.backend.music.albums.edit'), route('admin.music.albums.edit', $id));
});
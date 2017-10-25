<?php

Breadcrumbs::register('admin.music.artists.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.music.artists.management'), route('admin.music.artists.index'));
});

Breadcrumbs::register('admin.music.artists.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.music.artists.index');
    $breadcrumbs->push(trans('menus.backend.music.artists.create'), route('admin.music.artists.create'));
});

Breadcrumbs::register('admin.music.artists.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.music.artists.index');
    $breadcrumbs->push(trans('menus.backend.music.artists.view'), route('admin.music.artists.show', $id));
});

Breadcrumbs::register('admin.music.artists.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.music.artists.index');
    $breadcrumbs->push(trans('menus.backend.music.artists.edit'), route('admin.music.artists.edit', $id));
});
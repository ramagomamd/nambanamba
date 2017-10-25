<?php

Breadcrumbs::register('admin.music.tracks.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.music.tracks.management'), route('admin.music.tracks.index'));
});

Breadcrumbs::register('admin.music.tracks.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.music.tracks.index');
    $breadcrumbs->push(trans('menus.backend.music.tracks.create'), route('admin.music.tracks.create'));
});

Breadcrumbs::register('admin.music.tracks.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.music.tracks.index');
    $breadcrumbs->push(trans('menus.backend.music.tracks.view'), route('admin.music.tracks.show', $id));
});

Breadcrumbs::register('admin.music.tracks.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.music.tracks.index');
    $breadcrumbs->push(trans('menus.backend.music.tracks.edit'), route('admin.music.tracks.edit', $id));
});
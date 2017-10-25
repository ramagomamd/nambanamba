<?php

Breadcrumbs::register('admin.music.genres.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.music.genres.management'), route('admin.music.genres.index'));
});

Breadcrumbs::register('admin.music.genres.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.music.genres.index');
    $breadcrumbs->push(trans('menus.backend.music.genres.create'), route('admin.music.genres.create'));
});

Breadcrumbs::register('admin.music.genres.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.music.genres.index');
    $breadcrumbs->push(trans('menus.backend.music.genres.view'), route('admin.music.genres.show', $id));
});

Breadcrumbs::register('admin.music.genres.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.music.genres.index');
    $breadcrumbs->push(trans('menus.backend.music.genres.edit'), route('admin.music.genres.edit', $id));
});
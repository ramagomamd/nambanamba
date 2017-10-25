<?php

Breadcrumbs::register('admin.music.categories.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.music.categories.management'), route('admin.music.categories.index'));
});

Breadcrumbs::register('admin.music.categories.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.music.categories.index');
    $breadcrumbs->push(trans('menus.backend.music.categories.create'), route('admin.music.categories.create'));
});

Breadcrumbs::register('admin.music.categories.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.music.categories.index');
    $breadcrumbs->push(trans('menus.backend.music.categories.view'), route('admin.music.categories.show', $id));
});

Breadcrumbs::register('admin.music.categories.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.music.categories.index');
    $breadcrumbs->push(trans('menus.backend.music.categories.edit'), route('admin.music.categories.edit', $id));
});
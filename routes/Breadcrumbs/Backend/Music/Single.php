<?php

Breadcrumbs::register('admin.music.singles.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.music.singles.management'), route('admin.music.singles.index'));
});

Breadcrumbs::register('admin.music.singles.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.music.singles.index');
    $breadcrumbs->push(trans('menus.backend.music.singles.create'), route('admin.music.singles.create'));
});

Breadcrumbs::register('admin.music.singles.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.music.singles.index');
    $breadcrumbs->push(trans('menus.backend.music.singles.edit'), route('admin.music.singles.edit', $id));
});
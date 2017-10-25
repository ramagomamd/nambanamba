<?php

Breadcrumbs::register('music.albums.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('labels.frontend.music.albums.management'), route('music.albums.index'));
});

Breadcrumbs::register('music.albums.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('music.albums.index');
    $breadcrumbs->push(trans('menus.frontend.music.albums.view'), route('music.albums.show', $id));
});
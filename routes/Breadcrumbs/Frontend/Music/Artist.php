<?php

Breadcrumbs::register('music.artists.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('labels.frontend.music.artists.management'), route('music.artists.index'));
});

Breadcrumbs::register('music.artists.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('music.artists.index');
    $breadcrumbs->push(trans('menus.frontend.music.artists.view'), route('music.artists.show', $id));
});
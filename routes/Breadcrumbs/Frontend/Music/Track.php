<?php

Breadcrumbs::register('music.tracks.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('labels.frontend.music.tracks.management'), route('music.tracks.index'));
});

Breadcrumbs::register('music.tracks.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('music.tracks.index');
    $breadcrumbs->push(trans('menus.frontend.music.tracks.view'), route('music.tracks.show', $id));
});
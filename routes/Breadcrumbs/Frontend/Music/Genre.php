<?php

Breadcrumbs::register('music.genres.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('labels.frontend.music.genres.management'), route('music.genres.index'));
});

Breadcrumbs::register('music.genres.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('music.genres.index');
    $breadcrumbs->push(trans('menus.frontend.music.genres.view'), route('music.genres.show', $id));
});
<?php

Breadcrumbs::register('music.categories.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('labels.frontend.music.categories.management'), route('music.categories.index'));
});

Breadcrumbs::register('music.categories.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('music.categories.index');
    $breadcrumbs->push(trans('menus.frontend.music.categories.view'), route('music.categories.show', $id));
});
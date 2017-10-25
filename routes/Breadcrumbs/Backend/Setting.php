<?php

Breadcrumbs::register('admin.settings.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.settings.management'), route('admin.settings.index'));
});

Breadcrumbs::register('admin.settings.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.settings.index');
    $breadcrumbs->push(trans('menus.backend.settings.create'), route('admin.settings.create'));
});

Breadcrumbs::register('admin.settings.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.settings.index');
    $breadcrumbs->push(trans('menus.backend.settings.view'), route('admin.settings.show', $id));
});

Breadcrumbs::register('admin.settings.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.settings.index');
    $breadcrumbs->push(trans('menus.backend.settings.edit'), route('admin.settings.edit', $id));
});
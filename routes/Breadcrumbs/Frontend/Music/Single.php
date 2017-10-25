<?php

Breadcrumbs::register('music.singles.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('labels.frontend.music.singles.management'), route('music.singles.index'));
});
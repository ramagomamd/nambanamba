<?php

Breadcrumbs::register('music.dashboard', function ($breadcrumbs) {
    $breadcrumbs->push(trans('strings.frontend.dashboard.title'), route('music.dashboard'));
});

require __DIR__.'/Music.php';

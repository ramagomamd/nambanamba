<?php

namespace App\Listeners\Backend\Music\Album;

class AlbumEventListener
{
    /**
     * @var string
     */
    private $history_slug = 'User';

    /**
     * @param $event
     */
    public function onCreated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->album->id)
            ->withText('trans("history.backend.music.albums.created") <strong>{album}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'album_link' => ['admin.music.albums.show', $event->album->title, $event->album->id],
            ])
            ->log();
    }

     /**
     * @param $event
     */
    public function onUpdated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->album->id)
            ->withText('trans("history.backend.music.albums.updated") <strong>{album}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'album_link' => ['admin.music.albums.show', $event->album->title, $event->album->id],
            ])
            ->log();
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->album->id)
            ->withText('trans("history.backend.music.albums.deleted") <strong>{album}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'album_string' => $event->album->title,
            ])
            ->log();
    }

    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Music\Album\AlbumCreated::class,
            '\App\Listeners\Backend\Music\Album\AlbumEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Music\Album\AlbumUpdated::class,
            '\App\Listeners\Backend\Music\Album\AlbumEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Music\Album\AlbumDeleted::class,
            '\App\Listeners\Backend\Music\Album\AlbumEventListener@onDeleted'
        );
    }

}

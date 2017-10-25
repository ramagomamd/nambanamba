<?php

namespace App\Listeners\Backend\Music\Single;

class SingleEventListener
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
            ->withEntity($event->single->id)
            ->withText('trans("history.backend.music.singles.created") <strong>{single}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'single_link' => ['admin.music.tracks.show', $event->single->track->full_title, 
                                    $event->single->track->id],
            ])
            ->log();
    }

     /**
     * @param $event
     */
    public function onUpdated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->single->id)
            ->withText('trans("history.backend.music.singles.updated") <strong>{single}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'single_link' => ['admin.music.tracks.show', $event->single->track->full_title, 
                                    $event->single->track->id],
            ])
            ->log();
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->single->id)
            ->withText('trans("history.backend.music.singles.deleted") <strong>{single}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'single_string' => $event->single->track->full_title,
            ])
            ->log();
    }

    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Music\Single\SingleCreated::class,
            '\App\Listeners\Backend\Music\Single\SingleEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Music\Single\SingleUpdated::class,
            '\App\Listeners\Backend\Music\Single\SingleEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Music\Single\SingleDeleted::class,
            '\App\Listeners\Backend\Music\Single\SingleEventListener@onDeleted'
        );
    }

}

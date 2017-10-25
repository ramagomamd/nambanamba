<?php

namespace App\Listeners\Backend\Music\Category;

class CategoryEventListener
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
            ->withEntity($event->category->id)
            ->withText('trans("history.backend.music.categories.created") <strong>{category}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'category_link' => ['admin.music.categories.show', $event->category->name, $event->category->id],
            ])
            ->log();
    }

     /**
     * @param $event
     */
    public function onUpdated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->category->id)
            ->withText('trans("history.backend.music.categories.updated") <strong>{category}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'category_link' => ['admin.music.categories.show', $event->category->name, $event->category->id],
            ])
            ->log();
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->category->id)
            ->withText('trans("history.backend.music.categories.deleted") <strong>{category}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'category_string' => $event->category->name,
            ])
            ->log();
    }

    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Music\Category\CategoryCreated::class,
            '\App\Listeners\Backend\Music\Category\CategoryEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Music\Category\CategoryUpdated::class,
            '\App\Listeners\Backend\Music\Category\CategoryEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Music\Category\CategoryDeleted::class,
            '\App\Listeners\Backend\Music\Category\CategoryEventListener@onDeleted'
        );
    }

}

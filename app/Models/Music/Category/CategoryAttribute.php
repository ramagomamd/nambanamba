<?php

namespace App\Models\Music\Category;

trait CategoryAttribute
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

	public function getShowButtonAttribute()
    {
        return '<a href="'.route('admin.music.categories.show', $this).'" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.view').'"></i></a> ';
    }

     /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.music.categories.edit', $this).'" class="btn btn-xs btn-primary"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.edit').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.music.categories.destroy', $this).'"
             data-method="delete"
             data-trans-button-cancel="'.trans('buttons.general.cancel').'"
             data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
             data-trans-title="'.trans('strings.backend.general.are_you_sure').'"
             class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.delete').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeleteActionAttribute()
    {
        return '<a href="'.route('admin.music.categories.destroy', $this).'"
             data-method="delete"
             data-trans-button-cancel="'.trans('buttons.general.cancel').'"
             data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
             data-trans-title="'.trans('strings.backend.general.are_you_sure').'"
             class="btn btn-md btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.delete').'"></i> Delete</a> ';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
    	return
            $this->getShowButtonAttribute().
            $this->getDeleteButtonAttribute();
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = title_case($value);
    }
    
    public function getNameAttribute($value)
    {
        return title_case($value);
    }

    public function getSingleListsAttribute()
    {
        $singles = $this->singles()->with('tracks.artists', 'genres', 'categories')
                ->latest()->simplePaginate(10);

        return view('backend.music.singles.list', compact('singles'));
    }

    public function getAlbumListsAttribute()
    {
        $albums = $this->albums()->with('artists', 'genres', 'categories')
                ->latest()->simplePaginate(10);

        return view('backend.music.albums.list', compact('albums'));
    }
}
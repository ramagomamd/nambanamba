<?php

namespace App\Models\Music\Artist;
use Illuminate\Support\Facades\Cache;

trait ArtistAttribute
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

	public function getShowButtonAttribute()
    {
        return '<a href="'.route('admin.music.artists.show', $this).'" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.view').'"></i></a> ';
    }

     /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.music.artists.edit', $this).'" class="btn btn-xs btn-primary"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.edit').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.music.artists.destroy', $this).'"
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
        return '<a href="'.route('admin.music.artists.destroy', $this).'"
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

    public function getImageAttribute()
    {
        if ($this->hasMedia('image')) {
            return $this->getFirstMedia('image');
        } elseif ($cover = Cache::get('artist_image')) {
            if (!$cover->hasMedia('image')) return null;
            return $cover->getFirstMedia('image');
        } else {
            return null;
        }
    }

    public function getTracksListAttribute()
    {
        return view('backend.music.tracks.list')
                ->with('tracks', $this->tracks);
    }  

    public function getSinglesAttribute()
    {
        return $this->tracks()->where('trackable_type', 'singles');
    }

    public function getIsUnknownAttribute()
    {
        return $this->id === self::UNKNOWN_ID;
    }

    public function getIsVariousAttribute()
    {
        return $this->id === self::VARIOUS_ID;
    }

    /**
     * Get the "Various Artists" object.
     *
     * @return Artist
     */
    public static function getVariousArtist()
    {
        return self::find(self::VARIOUS_ID);
    }
}
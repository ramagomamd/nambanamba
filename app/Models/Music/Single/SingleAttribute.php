<?php

namespace App\Models\Music\Single;

use Illuminate\Support\Facades\Cache;

trait SingleAttribute
{
	public function getShowButtonAttribute()
    {
        return '<a href="'.route('admin.music.singles.show', $this).'" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.view').'"></i></a> ';
    }

     /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.music.singles.edit', $this).'" class="btn btn-xs btn-primary"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.edit').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.music.singles.destroy', $this).'"
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
        return '<a href="'.route('admin.music.singles.destroy', $this).'"
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
            $this->track->getShowButtonAttribute().
            $this->getEditButtonAttribute().
            $this->getDeleteButtonAttribute();
    }

    public function getCoverAttribute()
    {
        if ($cover = Cache::get('single_cover')) {
            if (!$cover->hasMedia('image')) return null;
            return $cover->getFirstMedia('image');
        } else {
            return null;
        }
    }

    public function getArtistsLink($type = "admin")
    {
        $artists = $this->artists;

        if ($artists->count() > 1) {
            $links = [];
            foreach ($artists as $artist) {
                $links[] = '<a href="'.route("{$type}.music.artists.show", $artist).'"> '.$artist->name.'</a>';
            }

            if (collect($links)->count() == 2) {

                $artists = implode(' and ', $links); 

                return $artists;
            } else {

                $last = array_pop($links); 
                $artists = implode(', ', $links); 
                $artists .= ' and '.$last; 

                return $artists;
            }
        } elseif ($artists->count() == 1) {
                return '<a href="'.route("{$type}.music.artists.show", $artists->first()).'">'
                        .$artists->first()->name.'</a>';
        }
        return null;
    }
}
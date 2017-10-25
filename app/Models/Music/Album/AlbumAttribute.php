<?php

namespace App\Models\Music\Album;
use Illuminate\Support\Facades\Cache;

trait AlbumAttribute 
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

	public function getShowButtonAttribute()
    {
        return '<a href="'.route('admin.music.albums.show', [$this->category, $this->genre, $this]).'" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.view').'"></i></a> ';
    }

     /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.music.albums.edit', $this).'" class="btn btn-xs btn-primary"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.edit').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.music.albums.destroy', $this).'"
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
        return '<a href="'.route('admin.music.albums.destroy', $this).'"
             data-method="delete"
             data-trans-button-cancel="'.trans('buttons.general.cancel').'"
             data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
             data-trans-title="'.trans('strings.backend.general.are_you_sure').'"
             class="btn btn-md btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.delete').'"></i> Delete Album</a> ';
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

    /**
     * Get a string path for the album.
     *
     * @return string
     */
    public function path()
    {
        return "/categories/{$this->category->slug}/{$this->genre->slug}/albums/{$this->slug}";
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

    public function getArtistsTitleCommaAttribute()
    {
        if ($this->artists) {
            $artists = $this->artists;

            if ($artists->count() > 1) {
                $titles = [];
                foreach ($artists as $artist) {
                    $titles[] = $artist->name;
                }

                if (collect($titles)->count() == 2) {

                    $artists = implode(' and ', $titles); 

                    return $artists;
                } else {

                    $last = array_pop($titles); 
                    $artists = implode(', ', $titles); 
                    $artists .= ' and '.$last; 

                    return $artists;
                }
            } elseif ($artists->count() == 1) {
                    return $artists->first()->name;
            }

        } 
        return null;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = title_case($value);
    }

    public function getTitleAttribute($value)
    {
        return title_case($value);
    }

    public function getFullTitleAttribute()
    {
        return title_case("{$this->artists_title_comma} - {$this->title} Full {$this->type}");
    }

    public function getFullerTitleAttribute()
    {
        return title_case("{$this->artists_title_comma} - {$this->title}");
    }

    public function getTracksListAttribute()
    {
        $tracks = $this->tracks()->with('artists', 'trackable')->latest()->paginate(10);

        return view('backend.music.albums.tracks', compact('tracks'));
    }

    public function getCoverAttribute()
    {
        if ($this->hasMedia('cover')) {
            return $this->getFirstMedia('cover');
        } elseif ($cover = Cache::get('album_cover')) {
            if (!$cover->hasMedia('image')) return null;
            return $cover->getFirstMedia('image');
        } else {
            return null;
        }
    }

    public function getFullSlugAttribute()
    {
        return str_slug($this->artist->name . ' - ' . $this->title);
    }

    public function getZipAttribute()
    {
        return $this->hasMedia('zip') ? $this->getFirstMedia('zip') : null;
    }

    public function getPlayTimeAttribute()
    {
        $tracks = $this->tracks;

        $seconds = 0;
        foreach ($tracks as $track) {
            $duration = substr($track->duration, 0, -4);
            list($min, $sec) = explode(':', $duration);
            $seconds += $min * 60;
            $seconds += $sec; 
        }
        $minutes = floor($seconds / 60);
        $seconds -= $minutes *60;

        return sprintf('%02d min %02d sec', $minutes, $seconds);
    }   
}
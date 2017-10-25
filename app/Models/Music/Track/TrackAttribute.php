<?php

namespace App\Models\Music\Track;

use Illuminate\Support\Facades\Cache;

trait TrackAttribute
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

	public function getShowButtonAttribute()
    {
        return '<a href="'.route('admin.music.tracks.show', [$this->trackable->category, 
            $this->trackable->genre, $this->trackable_type, $this->trackable, $this]).'" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.view').'"></i></a> ';
    }

     /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.music.tracks.edit', $this).'" class="btn btn-xs btn-primary"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.edit').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.music.tracks.destroy', $this).'"
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
        return '<a href="'.route('admin.music.tracks.destroy', $this).'"
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
            $this->getShowButtonAttribute();
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = title_case($value);
    }

    public function getTitleAttribute($value)
    {
        return title_case($value);
    }

    public function getBitrateAttribute($value)
    {
        $value =  (integer) ($value/1000);

        return  $value . ' kbps';
    }

    public function getFileAttribute()
    {
        if ($file = $this->getMedia('file')->first()) {
            return $file;
        }
        return null;
    }

    public function getCoverAttribute()
    {
        if ($this->hasMedia('cover')) {
            return $this->getFirstMedia('cover');
        } elseif ($this->trackable->hasMedia('cover')) {
            return $this->trackable->getFirstMedia('cover');
        } elseif ($cover = Cache::get('track_cover')) {
            if (!$cover->hasMedia('image')) return null;
            return $cover->getFirstMedia('image');
        } else {
            return null;
        }
    }

    public function getDurationAttribute($value)
    {
        return $value . ' min';
    }

    public function getFullTitleAttribute()
    {
        return "{$this->artists_title_comma} - {$this->title} {$this->features_title_comma}";
    }

    public function getBelongsToAttribute()
    {
        if ($this->trackable_type == 'albums') {
            $route = route('admin.music.' . $this->trackable_type . '.show', 
                $this->trackable);
            return '
                <tr>
                    <td>
                        <em>
                            ' . title_case(str_singular($this->trackable_type)) . '
                        </em>
                    </td>
                    <td>
                        <strong>
                            <a href="' . $route . '">'. $this->trackable->title . '</a>
                        </strong>
                    </td>
                </tr>';
        } elseif ($this->trackable_type == 'singles') {
            $route = route('admin.music.' . $this->trackable_type . '.index');
            return '
                <tr>
                    <td>
                        <em> 
                            Album
                        </em>
                    </td>
                    <td>
                    <strong>
                        <a href="' . $route . '"> '. title_case($this->trackable_type) . '</a>
                    </strong>
                </td>
                </tr>';
        } 
        return null; 
    }

    public function getAllArtistsAttribute()
    {
        $artists = $this->artists->reject(function($artist) {
            return $artist->pivot->role != 'main';
        });

        return $artists;
    }

    public function getArtistsLink($type = "admin")
    {
        if ($this->artists) {
            $artists = $this->artists->reject(function($artist) {
                return $artist->pivot->role != 'main';
            });

            if ($artists->count() > 1) {
                $links = [];
                foreach ($artists as $artist) {
                    $links[] = '<a href="'.route("{$type}.music.artists.show", $artist).'"> '.$artist->name.'</a>';
                }

                if (collect($links)->count() == 2) {

                    $artists = implode(' and ', $links); 

                    return $artists . $this->getFeaturesLink($type);
                } else {

                    $last = array_pop($links); 
                    $artists = implode(', ', $links); 
                    $artists .= ' and '.$last; 

                    return $artists . $this->getFeaturesLink($type);
                }
            } elseif ($artists->count() == 1) {
                    return '<a href="'.route("{$type}.music.artists.show", $artists->first()).'"> '.$artists->first()->name.'</a>' 
                        . $this->getFeaturesLink($type);
            }

        } else {
            return null;
        }
    }

    public function getArtistsTitleCommaAttribute()
    {
        if ($this->artists) {
            $artists = $this->artists->reject(function($artist) {
                return $artist->pivot->role != 'main';
            });

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

        } else {
            return null;
        }
    }

    public function getAlbumArtistLink($type = "admin")
    {
        return $this->trackable->getArtistsLink($type);
    }

    public function getProducerLink($type = "admin")
    {
        $producer = $this->artists->reject(function($artist) {
            return $artist->pivot->role != 'producer';
        });

        if ($producer->isNotEmpty()) {
            return '<a href="'.route("{$type}.music.artists.show", $producer->first()).'"> 
                '.$producer->first()->name.'</a>';
        }
        return null;
    }

    public function getAllFeaturesAttribute()
    {
        $artists = $this->artists->reject(function($artist) {
            return $artist->pivot->role != 'feature';
        });

        return $artists;
    }

    public function getFeaturesLink($type = "admin")
    {
        if ($this->artists) {
            $artists = $this->artists->reject(function($artist) {
                return $artist->pivot->role != 'feature';
            });

            if($artists->count() > 1) {
                $links = [];
                foreach ($artists as $artist) {
                    $links[] = '<a href="'.route("{$type}.music.artists.show", $artist).'"> ' .$artist->name. '</a>';
                }

                if (collect($links)->count() == 2) {

                    $artists = implode(' and ', $links); 

                    return ' ft ' . $artists;
                } else {

                    $last = array_pop($links); 
                    $artists = implode(', ', $links); 
                    $artists .= ' and ' . $last; 

                    return ' ft ' .$artists;
                }
            } elseif( $artists->count() == 1) {
                return ' ft <a href="'.route("{$type}.music.artists.show", $artists->first()).'"> '.$artists->first()->name.'</a>';
            }
            
        } else {
            return null;
        }
    }

    public function getFeaturesTitleCommaAttribute()
    {
        if ($this->artists) {
            $artists = $this->artists->reject(function($artist) {
                return $artist->pivot->role != 'feature';
            });

            if($artists->count() > 1) {
                $links = [];
                foreach ($artists as $artist) {
                    $links[] = $artist->name;
                }

                if (collect($links)->count() == 2) {

                    $artists = implode(' and ', $links); 

                    return ' ft ' . $artists;
                } else {

                    $last = array_pop($links); 
                    $artists = implode(', ', $links); 
                    $artists .= ' and ' . $last; 

                    return ' ft ' .$artists;
                }
            } elseif( $artists->count() == 1) {
                return ' ft ' .$artists->first()->name;
            }
            
        } else {
            return null;
        }
    }

    

    public function getFeaturesAttribute()
    {
        if ($this->artists->count() > 1) {
            $features = [];
            $artists = $this->artists->reject(function($artist) {
                return $artist->pivot->role != 'feature';
            });

            foreach($artists as $artist) {
                $features[] = $artist->name;
            }

            return collect($features)->implode(',');

        } elseif ($this->artists->count() == 1) {
            if($this->artists->first()->pivot->role == 'feature') {
                return $this->artists->first()->name;
            }
        } else {
            return null;
        }
    }

    public function getArtistNamesAttribute()
    {
        if ($this->artists->count() > 1) {
            $main = [];
            $artists = $this->artists->reject(function($artist) {
                return $artist->pivot->role != 'main';
            });

            foreach($artists as $artist) {
                $main[] = $artist->name;
            }

            return collect($main)->implode(',');

        } elseif ($this->artists->count() == 1) {
            if($this->artists->first()->pivot->role == 'main') {
                return $this->artists->first()->name;
            }
        } else {
            return null;
        }
    }

    public function getArtistDashAttribute()
    {
        if ($this->artists->count() > 1) {
            $main = [];
            $artists = $this->artists->reject(function($artist) {
                return $artist->pivot->role != 'main';
            });

            foreach($artists as $artist) {
                $main[] = $artist->name;
            }

            return collect($main)->implode('-');

        } elseif ($this->artists->count() == 1) {
            if($this->artists->first()->pivot->role == 'main') {
                return $this->artists->first()->name;
            }
        } else {
            return null;
        }
    }

    public function getFeaturesDashAttribute()
    {
        if ($this->artists->count() > 1) {
            $features = [];
            $artists = $this->artists->reject(function($artist) {
                return $artist->pivot->role != 'feature';
            });

            foreach($artists as $artist) {
                $features[] = $artist->name;
            }

            return collect($features)->implode('-');

        } elseif ($this->artists->count() == 1) {
            if($this->artists->first()->pivot->role == 'feature') {
                return $this->artists->first()->name;
            }
        } else {
            return null;
        }
    }

    public function getProducerAttribute()
    {
        $producer = $this->artists->reject(function($artist) {
            return $artist->pivot->role != 'producer';
        });

        if ($producer->isNotEmpty()) {
            return $producer->first()->name;
        }
        return null;
    }

    public function getPathAttribute()
    {
        return $this->file->getPath();
    }

    public function getUrlAttribute()
    {
        return $this->file->getUrl();
    }

    public function getSizeAttribute()
    {
        return $this->file->getHumanReadableSizeAttribute();
    }

}
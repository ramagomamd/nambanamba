<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Setting;
use App\Http\Requests\Backend\Setting\ManageSettingRequest;
use App\Http\Requests\Backend\Setting\StoreSettingRequest;
use App\Http\Requests\Backend\Setting\UpdateSettingRequest;
use App\Repositories\Backend\SettingRepository;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Backend\Music\CacheRepository;

class SettingsController extends Controller
{
    protected $settings;
    protected $cache;

    public function __construct(SettingRepository $settings, CacheRepository $cache)
    {
        $this->settings = $settings;
        $this->cache = $cache;
    }

    public function index(ManageSettingRequest $request)
    {
        $settings = $this->settings->query()->orderBy('order', 'ASC')->get();

        return view('backend.settings.index', compact('settings'));
    }

    public function store(StoreSettingRequest $request)
    {
        $lastSetting = $this->settings->query()->orderBy('order', 'DESC')->first();

        if (is_null($lastSetting)) {
            $order = 0;
        } else {
            $order = intval($lastSetting->order) + 1;
        }

        $request->merge(['order' => $order]);
        $request->merge(['value' => '']);

        $this->settings->query()->create($request->all());

        return back()->with([
            'flash_success'    => 'Successfully Created Settings'
        ]);
    }

    public function update(Request $request)
    {
        // Cache::flush();
        $settings = $this->settings->getAll();

        foreach ($settings as $setting) {
            $this->cache->clear('settings', $setting->key);
            // Cache::forget("settings/{$setting->key}");
            $content = $this->settings->getContentBasedOnType($request, (object) [
                'type'    => $setting->type,
                'field'   => $setting->key,
                'details' => $setting->details,
            ]);

            if ($setting->type == 'image' && $content !== null) {
                if ($setting->hasMedia('image')) {
                    $setting->getMedia('image')->each->delete();
                }
                $media = $setting->addMedia($content)
                    ->usingName($setting->key)
                    ->usingFileName(str_slug($setting->key) . ".{$content->extension()}")
                    ->toMediaLibrary('image');
                $content = $media->name;
            }

            if ($setting->type !== 'image' && $content === null && isset($setting->value)) {
                $content = $setting->value;
            } 

            $setting->value = $content ?? "Not Set";
            $setting->save();
            // Cache::forever($setting->key, $setting->fresh());
        }
        $this->cache->findOrMake('settings');

        return back()->withFlashSuccess('Successfully Saved Settings');
    }

    public function destroy(Setting $setting, ManageSettingRequest $request)
    {
        Cache::forget($setting->key);
        $data = $this->settings->delete($setting);

        return back()->with($data);
    }

    public function move_up(Setting $setting, ManageSettingRequest $rrequest)
    {
        $swapOrder = $setting->order;
        $previousSetting = $this->settings->query()->where('order', '<', $swapOrder)
                            ->orderBy('order', 'DESC')->first();
        $data = [
            'flash_danger'    => 'This is already at the top of the list'
        ];

        if (isset($previousSetting->order)) {
            $setting->order = $previousSetting->order;
            $setting->save();
            $previousSetting->order = $swapOrder;
            $previousSetting->save();

            $data = [
                'flash_success'    => "Moved {$setting->display_name} setting order up"
            ];
        }

        return back()->with($data);
    }

    public function delete_value(Setting $setting, ManageSettingRequest $rrequest)
    {
        if (isset($setting->id)) {
            Cache::forget($setting->key);
            if ($setting->value) {
                // If the type is an image... Then delete it
                if ($setting->type == 'image') {
                    if ($setting->hasMedia('image')) {
                        $setting->getMedia('image')->each->delete();
                    }
                }
                $setting->value = '';
                $setting->save();
                $data = [
                    'flash_success'    => "Successfully removed {$setting->display_name} value"
                ];
            } else {
                $data = [
                    'flash_danger'    => "{$setting->display_name} value could not be cleared because it's empty"
                ];
            }
        }

        return back()->with($data);
    }

    public function move_down(Setting $setting, ManageSettingRequest $rrequest)
    {
        $swapOrder = $setting->order;

        $previousSetting = $this->settings->query()->where('order', '>', $swapOrder)->orderBy('order', 'ASC')->first();
        $data = [
            'flash_danger'    => 'This is already at the bottom of the list'
        ];

        if (isset($previousSetting->order)) {
            $setting->order = $previousSetting->order;
            $setting->save();
            $previousSetting->order = $swapOrder;
            $previousSetting->save();

            $data = [
                'flash_success'    => "Moved {$setting->display_name} setting order down"
            ];
        }

        return back()->with($data);
    }
}

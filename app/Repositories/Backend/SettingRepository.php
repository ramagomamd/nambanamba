<?php 

namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use App\Models\Setting\Setting;
use Illuminate\Database\Eloquent\Model;
use App\Services\Music\Facades\Music;
use App\Helpers\Validators\Mimes;
use Illuminate\Http\Request;

class SettingRepository extends BaseRepository
{
	const MODEL = Setting::class;
	protected $validate;

	public function __construct(Mimes $validate)
	{
		$this->validate = $validate;
	}

	public function getContentBasedOnType(Request $request, $row)
    {
        $content = null;
        switch ($row->type) {

            /********** IMAGE TYPE **********/
            case 'image':
                $image = $request->file($row->field); 
                if ($image && $image->isValid() && $this->validate->image($image)) 
                {
                    return $image;
                }
            // no break

            /********** ALL OTHER TEXT TYPE **********/
            default:
                $value = $request->input($row->field);
                $options = json_decode($row->details);
                if (isset($options->null)) {
                    return $value == $options->null ? null : $value;
                }

                return $value;
        }

        return $content;
    }

    public function delete(Setting $setting)
	{
		if ($setting->type == 'image') {
            if ($setting->image) $setting->image->delete();
        }

		if ($setting->delete()) {
			$data = [
				'flash_success'    => 'Successfully Deleted Setting'
			];
		} else {
			$data = [
				'flash_success' => 'Something went wrong during deletion'
			];
		}	
		return $data;
	}
}
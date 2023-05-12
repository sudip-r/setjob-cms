<?php

namespace App\Http\ViewComposers;


use App\AlterBase\Models\User\Module;
use Illuminate\Database\Eloquent\Collection;
use App\AlterBase\Models\Setting\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FooterComposer
{
    public function compose(View $view)
    {
        $setting = $this->loadSettings();

        return $view->with('setting',$setting);
    }

    /**
     * Load settings from file or db
     *
     * @return Array|Illuminate\Database\Eloquent\Collection
     */
    private function loadSettings()
    {
        try {
            return json_decode(Storage::get('public/settings/settings.json'), false);
        } catch (\Exception $e) {
            //If data could not be read from the settings.json file
            return Setting::find(1);
        }
    }
}
<?php

namespace App\Http\ViewComposers;


use App\AlterBase\Models\User\Module;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use App\AlterBase\Models\Meta\City;
use Illuminate\View\View;

class CitiesListComposer
{
    public function compose(View $view)
    {
        $countries = config('cms.countries');

        $cities = [];


        $filePath = storage_path('app/public/meta');

        if(!file_exists($filePath))
            mkdir($filePath, 0775);

        if(!file_exists($filePath."/cities.json")){
            $cities = City::whereIn('country_id', $countries)->get(['id', 'name'])->pluck('name', 'id');
            
            Storage::put('public/meta/cities.json', json_encode($cities));
        }else{
            $cities = Storage::get('public/meta/cities.json');
        }
        return $view->with('cities',$cities);
    }
}
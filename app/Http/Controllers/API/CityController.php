<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\AlterBase\Models\Meta\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function cities(Request $request)
    {
        $countries = config('cms.countries');

        $cities = [];

        $str = $request->q;

        $cities = City::whereIn('country_id', $countries)->where('name', 'like', $str.'%')->select(['id', 'name'])->paginate(100);

        return response(['cities' => $cities->toArray()]);
    }
}

<?php

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\alterBase\Models\User\User;

/**
 * Get list of months
 *
 * @return array
 */
function getMonths()
{
    return [
        1 => "Jan",
        2 => "Feb",
        3 => "Mar",
        4 => "Apr",
        5 => "May",
        6 => "Jun",
        7 => "Jul",
        8 => "Aug",
        9 => "Sep",
        10 => "Oct",
        11 => "Nov",
        12 => "Dec",
    ];
}

/**
 * Get list of days
 *
 * @return array
 */
function getDays()
{
    $days = [];

    for ($day = 1; $day <= 32; $day++) {
        $days[$day] = $day;
    }

    return $days;
}

/**
 * Upload image
 *
 * @param $request
 * @return string
 */
function uploadImage($request, $imageName, $path)
{
    $image = $request->file($imageName);
    $imageName = rand(1, 999999) . time() . '.' . $image->getClientOriginalExtension();

    $destinationPath = public_path($path);
    $image->move($destinationPath, $imageName);

    return $imageName;
}

/**
 * Get authentication guard
 *
 * @return String
 */
function getGuard()
{
    if (Auth::guard('web')->check()) {
        return "web";
    } elseif (Auth::guard('business')->check()) {
        return "business";
    } elseif (Auth::guard('client')->check()) {
        return "client";
    }
}

/**
 * Redirect users according to guard
 *
 * @param $guard
 * @return Illuminate\Support\Facades\Redirect
 */
function redirectToGuard($guard)
{
    switch ($guard) {
        case 'web':
            return redirect()->intended('alter-admin');
        case 'business':
            return redirect()->intended('business');
        case 'client':
            return redirect()->intended('client');
    }
}

/**
 * Image path filter for custom file uploads
 *
 * @param $str
 * @return String
 */
function mpath($str)
{
    if(isUrl($str))
      return $str;

    if(!file_exists(public_path($str)))
        return asset("cms/dist/img/default.png");

    if (env('APP_ENV') == 'local') {
        return asset($str);
    }

    return env('IMG_URL', asset('')) . '/' . $str;
}

/**
 * Check if string is a url
 * 
 * @param $str
 * @return Boolean
 */
function isUrl($str)
{
  if (filter_var($str, FILTER_VALIDATE_URL)) {
    return true;
  } 
  return false;
}

/**
 * Save Image With watermark
 *
 * @param $destinationPath
 * @param $filename
 * @param Image
 */
function saveImageWithWatermark($destinationPath, $filename, $image)
{

    $path = $destinationPath . $filename;

    $myImage = Image::make($image->getRealPath());

    $waterMark = public_path('uploads/watermark/small-logo.png');

    $myImage->insert($waterMark, 'bottom-right');


    $myImage->save($path);
}

/**
 * Save Image Without watermark
 *
 * @param $destinationPath
 * @param $filename
 * @param Image
 */
function saveImageWithOutWatermark($destinationPath, $filename, $image)
{

    $path = $destinationPath . $filename;
    $myImage = Image::make($image->getRealPath());

    $myImage->save($path);
}

/**
 * Set redis cache
 * 
 * @param $key
 * @param $ttl
 * @param Clousure $callback
 * @return Function Callback
 */
function cacheRemember($key, $ttl, Closure $callback)
{
    if (env('CACHE_DRIVER') == 'redis') {
        $value = Redis::get($key);

        if (!is_null($value)) {
            return unserialize($value);
        }

        Redis::set($key, $value = serialize($callback()));

        Redis::expire($key, $ttl * 60);

        return unserialize($value);
    } else {
        return $callback();
    }
}

/**
 * Clear cache if cache driver is redis
 * 
 * @param $message
 * @return null
 */
function clearCache($message = '')
{
    if (env('CACHE_DRIVER') == 'redis') {
        try {
            if (
                env('APP_ENV') == 'production'
                || env('APP_ENV') == 'local'
                || env('APP_ENV') == 'development'
            ) {
                Redis::flushDB();

                logger('Cache Cleared! ' . $message);
            }
        } catch (\Exception $e) {
            logger((string)$e);
        }
    } else {
        logger('Driver not set to Redis. Log message - ' . $message);
        return null;
    }
}

/**
 * Trim words for output
 * 
 * @param $string
 * @param $words
 * @return String
 */
function trimWords($string, $words = 150)
{
    return Str::limit($string, $words, $end = '...');
}

/**
 * Get current username
 * 
 * @return String
 */
function currentUserName()
{
    return auth()->user()->name;
}

/**
 * Get Username By Id
 * 
 * @param $id
 * @return String
 */
function getUserName($id)
{
  return (User::find($id) != null) ? User::find($id)->name : "NA";
}

/**
 * Get Embed url
 * 
 * @param $url
 * @return String
 */
function getYoutubeEmbedUrl($url)
{
     $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
     $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

     $youtube_id = "";

    if (preg_match($longUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }

    if (preg_match($shortUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }
    if($youtube_id == "")
        return $url;
    $embed = 'https://www.youtube.com/embed/' . $youtube_id ;

    return '<iframe src="'.$embed.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
}
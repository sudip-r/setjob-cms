<?php

namespace App\Http\ViewComposers;


use App\AlterBase\Models\User\Module;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class AuthCheckComposer
{
    public function compose(View $view)
    {
        $user = null;

        if(auth()->user() != null)
            $user = auth()->user();

        return $view->with('user',$user);
    }
}
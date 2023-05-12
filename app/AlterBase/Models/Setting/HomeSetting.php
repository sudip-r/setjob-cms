<?php

namespace App\AlterBase\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $table = 'home_settings';

    protected $fillable = [
        'title',
        'sub_title',
        'left_col_title',
        'left_col_summary',
        'left_col_btn',
        'left_col_btn_link',
        'right_col_title',
        'right_col_summary',
        'right_col_btn',
        'right_col_btn_link',
    ];

}
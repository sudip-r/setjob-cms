<?php

namespace App\AlterBase\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Stripe extends Model
{
    protected $table = 'stripe';

    protected $fillable = [
        'live',
        'test_publishable_key',
        'test_secret_key',
        'live_publishable_key',
        'live_secret_key',
        'currency',
        'currency_symbol',
        'dashboard',
        'test_dashboard',
        'subscription_fee',
        'product_id',
        'price_id'
    ];

}
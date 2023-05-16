<?php

namespace App\Http\ViewComposers;

use App\AlterBase\Repositories\Setting\StripeRepository;
use App\AlterBase\Repositories\User\UserRepository;
use Illuminate\View\View;
use Stripe\StripeClient;

class SubscriptionCheckComposer
{
    public function compose(View $view)
    {
        $subscription = [
            'user' => null,
            'on_trial' => false,
            'active_subscription' => false,
        ];

        if (auth()->user() != null) {
            $subscription['user'] = auth()->user();
        }

        if ($subscription['user'] != null) {
            $days = dateDifference($subscription['user']->created_at);

            $subscription['on_trial'] = true;

            if ($days > 30) {
                $subscription['on_trial'] = false;
            }

            if ($subscription['user']->verified == "1" && ($subscription['user']->subscription_id != "" || $subscription['user']->subscription_id != null)) {
                $lastSub = dateDifference($subscription['user']->pm_last_four);
                if ($lastSub >= 30) //Check subscription status after 30 days
                {
                    $stripe = new StripeRepository(app());
                    $setting = $stripe->find(1);
                    $key = $setting->live_secret_key;
                    if ($setting->live == 0) {
                        //test
                        $key = $setting->test_secret_key;
                    }

                    $client = new \Stripe\StripeClient($key);

                    $sub = $client->subscriptions->retrieve(
                        $subscription['user']->subscription_id
                    );

                    
                    if ($sub != null) {
                        $current_period_start = date("Y-m-d H:i:s", "1684149715");

                        $user = new UserRepository(app());

                        $user->update($subscription['user']->id, ['pm_last_four' => $current_period_start]);

                        $subscription['active_subscription'] = true;
                    }
                }
            }

        }

        return $view->with('subscription', $subscription);
    }
}

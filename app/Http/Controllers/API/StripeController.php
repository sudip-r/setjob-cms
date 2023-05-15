<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\AlterBase\Repositories\User\UserRepository;
use App\AlterBase\Repositories\Setting\StripeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class StripeController extends Controller
{
    /**
     * UserRepository $user
     */
    private $user;

    /**
     * StripeRepository $stripe
     */
    private $stripe;

    /**
     * StripeController Constructor
     * 
     * @param UserRepository $user
     * @param StripeRepository $stripe
     */
    public function __construct(UserRepository $user, StripeRepository $stripe)
    {
        $this->user = $user;
        $this->stripe = $stripe;
    }

    /**
     * Add card for customer
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function addCard(Request $request)
    {
        $user = $this->user->find(auth()->user()->id);

        $stripe = $this->stripe->find(1);

        $key = $stripe->live_secret_key;
        if($stripe->live == 0)
        {
            //test
            $key = $stripe->test_secret_key;
        }

        if($key == "")
            return response(['success' => false, 'message' => 'No keys specified!']);

        if($user->stripe_id == "")
            return response(['success' => false, 'message' => 'User id not found!']);

        $client = new \Stripe\StripeClient($key);

        $card = $client->customers->createSource(
            $user->stripe_id,
            ['source' => $request->token]
        );

        $data['pm_type'] = $card->id;
        
        $data['subscription_id'] = $this->subscribe($stripe);

        $data['verified'] = "1";

        $data['pm_last_four'] = date("Y-m-d H:i"); 

        $this->user->update($user->id, $data);

        return response(['success' => true, 'message' => 'Subscription successful!']);
    }

    /**
     * Subscribe to monthly recurring fee
     * 
     * @param $stripe
     * @return String
     */
    private function subscribe($stripe)
    {
        $user = $this->user->find(auth()->user()->id);

        $key = $stripe->live_secret_key;
        if($stripe->live == 0)
        {
            //test
            $key = $stripe->test_secret_key;
        }

        $client = new \Stripe\StripeClient($key);

        $subscription = $client->subscriptions->create([
            'customer' => $user->stripe_id,
            'items' => [
              [
                'price' => $stripe->price_id,
               'quantity' => 1
              ],
            ],
          ]);

        return $subscription->id;
    }

}
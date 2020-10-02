<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymnetController extends Controller
{
    // 課金を実行
    public function oneTimePayment(Request $request) {

        $user = $request->user();

        if(!$user->subscribed('main')) {

            $payment_method = $request->payment_method;
            $plan = $request->plan;
            $user->newSubscription('main', $plan)->create($payment_method);
            $user->load('subscriptions');
        }

        return $this->status();

    }

    public function store(Request $request) {


    }
}

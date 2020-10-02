<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function getPaymentForm(Request $request) {
        // ログインしてからであれば（定期購買モデル）
        // 顧客の支払いメソッドの詳細を安全に集める
        $user = $request->user();
        // Auth::user()->createSetupIntent();
        // dd($request->user());
        return view('payment.form')->with([
            'intent' => $user->createSetupIntent()
        ]);
    }

    public function pay (Request $request) {
        try {
            dd($request);
            Stripe::setApiKey(config('services.stripe.key'));
            # トークンを取得
            $token = $request->stripeToken;

            # Customer の作成（保存）
            $customer = Customer::create(array(
                // 'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));

            # Customer に対して charge します:
            $charge = Charge::create(array(
                // 'customer' => $customer->id,
                'amount' => 10,
                'currency' => 'jpy',
                'description' => 'テスト単発決済',
                'source' => $request->stripeToken
            ));

            # Customer ID を保存しておき、その後また Charge する際に指定する
            // $charge = Stripe::Charge.create({
            //     amount: 2000,
            //     currency: 'jpy',
            //     customer: customer_id, # 保存しておいた Customer ID を利用する
            // });

            return back();
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

    }
}

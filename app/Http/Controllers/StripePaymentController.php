<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Stripe;

class StripePaymentController extends Controller{

    public function stripe(){
          //  $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_COMPANY'));
        // $stripe = new \Stripe\StripeClient(
        //     env('STRIPE_SECRET_COMPANY')
        //   );
        //   $new =  $stripe->accounts->create([
        //     'type' => 'custom',
        //     'country' => 'US',
        //     'email' => 'company@example.com',
        //     'capabilities' => [
        //         'card_payments' => ['requested' => true],
        //         'transfers' => ['requested' => true],
        //     ],
        // ]);
        // $new = \Stripe\Customer::create([
        //     'email' =>'Company@test.com',
        //     'name' => 'CompanyTest',
        //     'description' => "Contribee.com platform's user",
        // ]);

        // return User::create([
        //     'name' => 'company',
        //     'email' =>'company@example.com',
        //     'stripe_code' => $new->id,
        //     'password' => Hash::make('12345678'),
        // ]);
        // $user = User::first();
        // $card = $this->getPaymentMethods( $user->stripe_code);
        // // return $card;
        
        // try {
        //     $new=
        //     $payment_intent = \Stripe\PaymentIntent::create([
        //         'amount' => 1000,
        //         'currency' => 'usd',
        //         'transfer_data' => [
        //           'destination' => 'acct_1LWnzrQ86QE2TYiR',
        //         ],
        //       ]);
            //    \Stripe\PaymentIntent::create([
            //     'amount' => 110 * 100,
            //     'currency' => 'usd',
            //     'customer' => $user->stripe_code,
            //     // 'payment_method' => $card->data[0]->id,
            //     'off_session' => true,
            //     'confirm' => true
            // ]);
            // return $new;
        // }
        // catch (\Stripe\Exception\CardException $e){
        //     return response()->back()->with([
        //         'error' => 'Something went wrong. Error code: ' . $e->getMessage()
        //     ]);
        // }
        return view('stripe');
    }
    public function getPaymentMethods($customer_id)
{
    $payment_methods = \Stripe\PaymentMethod::all([
        'customer' => $customer_id, 
        'type' => 'card'
    ]);
    return $payment_methods;
}
    public function stripePost(Request $request){
        // return $request;
      try {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET_COMPANY'));
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => 10000,
            'currency' => 'usd',
            'transfer_group' => '{ORDER10}',
          ]);
          $user1 = User::whereId('3')->first();
          $user2 = User::whereId('4')->first();
          $transfer = \Stripe\Transfer::create([
            'amount' => 7000,
            'currency' => 'usd',
            'destination' => $user1->stripe_code,
            'transfer_group' => '{ORDER10}',
          ]);
          
          // Create a second Transfer to another connected account (later):
          // $transfer = \Stripe\Transfer::create([
          //   'amount' => 2000,
          //   'currency' => 'usd',
          //   'destination' => $user1->stripe_code,
          //   'transfer_group' => '{ORDER10}',
          // ]);
      } catch (\Throwable $th) {
        //throw $th;
      }
        // Stripe\Charge::create ([
        //         "amount" => 1000 * 100,
        //         "currency" => "usd",
        //         "source" => $request->stripeTokenCompany,
        //         "description" => "Test payment from Mohammed Obaid Company." 
        // ]);
        
       
      
        Session::flash('success', 'Payment successful!');
              
        return back();
    }

    // public function useCard($customer_id, $amount)
    // {
    //     $card = $this->getPaymentMethods($customer_id);

    //     try {
    //         \Stripe\PaymentIntent::create([
    //             'amount' => $amount * 100,
    //             'currency' => 'usd',
    //             'customer' => $customer_id,
    //             'payment_method' => $card->data[0]->id,
    //             'off_session' => true,
    //             'confirm' => true
    //         ]);
    //     }
    //     catch (\Stripe\Exception\CardException $e){
    //         return response()->back()->with([
    //             'error' => 'Something went wrong. Error code: ' . $e->getMessage()
    //         ]);
    //     }
    // }
    // public function getPaymentMethods($customer_id)
    // {
    //     $payment_methods = \Stripe\PaymentMethod::all([
    //         'customer' => $customer_id, 
    //         'type' => 'card'
    //     ]);
    //     return $payment_methods;
    // }
    
}

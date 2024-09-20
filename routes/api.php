<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/create-intent', function(Request $request){
    // Set your secret key. Remember to switch to your live secret key in production.
    // See your keys here: https://dashboard.stripe.com/apikeys
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

    $intent = $stripe->paymentIntents->create([
        'amount' => $request->amount,
        'currency' => 'usd',
        'automatic_payment_methods' => ['enabled' => true],
    ]);
    return response()->json($intent);
});

Route::get('/create-intent', function(Request $request){
    // Set your secret key. Remember to switch to your live secret key in production.
    // See your keys here: https://dashboard.stripe.com/apikeys
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

    $intent = $stripe->paymentIntents->create([
        'amount' => $request->amount,
        'currency' => 'usd',
        'automatic_payment_methods' => ['enabled' => true],
    ]);
    return response()->json($intent);
});
<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
    public function refund( Request $request )
    {
        $data = $request->validate([
            'payment_id' => 'numeric'
        ]);
        $payment = Payment::findOrFail($data['payment_id']);

        $order_code = $payment->order_code;
        $world_pay_gateway = new WorldPayGateWay();
        $response = $world_pay_gateway->refund($data['payment_id']);
        return redirect('/dashboard')->with('status', $response );
    }
    public function refund_create()
    {
        if( !Auth::user()){
            return redirect('/login');
        }
        if( !Auth::user()->customer ){
            return redirect('/')->with('status', 'Sorry you did not make payment yet');
        }
        $payments = Payment::whereHas('customer', function($query){
            $query->where('customer_id', '=', Auth::user()->customer->id );
        })->get();
        return view('order.refund', compact('payments'));
    }
}

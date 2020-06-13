@extends('layouts.app')

@section('content')
    @if (isset($payments))
        <form method="post" action="/payments/refund" id="my-payment-form" class="container mx-auto">
            @csrf
            <div class="payment-errors"></div>
            <div class="form-row mt-20"> 
                <label for="payment-id">
                    Select order
                </label>
                <select name="payment_id" id="payment-id" class="h-12 p-4 rounded border w-1/2">
                    @foreach ($payments as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->product->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <input type="submit" id="refund-order" value="Refund Order" class="bg-blue-500 px-4 py-2 rounded text-white mt-10" />
        </form>
    @else
        <p class="mt-20"><i>Sorry you did not make any payments</i></p>
    @endif
    
@endsection
<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Customer;
use WorldpayException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\WorldPayGateWay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Events\CustomerRegisteredEvent;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function searchApi(Request $request)
    {
        
        $data = $request->query();
        $data = Validator::make($request->query(), [
            'search' => 'string'
        ])->validate();
        
        try{
            $customers_found = Customer::query()
            ->where('first_name', 'LIKE', "%{$data['search']}%")
            ->orWhere('last_name', 'LIKE', "%{$data['search']}%")->get();
        }catch( \Exception $e ){
            return json_encode(['error' => $e->getMessage()]);
        }
        return $customers_found;
    }
    public function store(Request $request )
    {
        $data = $request->validate([
            'first_name' => 'string',
            'last_name' => 'string',
            'email'  => 'email',
            'api_site'  => 'url',
            'product_id' => 'numeric',
            '_payment_token' => 'json|nullable',
            'billing_address'  => 'string|nullable',
            'shipping_address'  => 'string|nullable',
            '_worldpay_token' => 'string',
            'address1'  => 'string',
            'postalCode' => 'numeric|alpha_num',
            'city'  => 'string',
            'countryCode'  => 'string'
        ]);
        $token = $data['_payment_token'] ? json_decode($data['_payment_token']) : $data['_worldpay_token'];
        $billing_address = [
            'address1' => $data['address1'],
            'postalCode' => $data['postalCode'],
            'city'      => $data['city'],
            'countryCode'  => $data['countryCode']
        ];
        DB::beginTransaction();
        try {
            $full_name = "{$data['first_name']} {$data['last_name']}";
        
            $customer = User::create(['name' => $full_name, 'email' => $data['email'], 'password' => Hash::make('swimghana')])
                ->customer()->create([
                    'first_name' => $data['first_name'],
                    'last_name'  =>$data['last_name'],
                    'api_site'  => $data['api_site']
                ]);
            $license = $customer->licenses()->create([
                'product_id' => $data['product_id'],
                'expiry_date' => $this->getOneYearDate(),
                'license_key' => Str::random()
            ]);

            $gateway = new WorldPayGateWay();

            $product = Product::find($data['product_id']);

            $payment = function($order_code) use($customer, $data, $token, $billing_address){
                return $customer->payments()->create([
                    'token' => $token,
                    'shipping_address' => $data['shipping_address'],
                    'billing_address'  => json_encode($billing_address),
                    'order_code'  => $order_code,
                    'product_id' => $data['product_id']
                ]);
            };
            $paid = $gateway->charge([
                'amount' => ($product->price * 100),
                'orderType' => 'RECURRING',
                'token' => $token,
                'name' => $product->title,
                'description' => $product->description,
                'order_code' => $customer->id,
                'billing_address' => $billing_address,
            ]);

            if( !($paid instanceof WorldpayException) ){
                $saved = $payment($paid);
            }else{
                DB::rollback();
                return redirect("/pay/{$product->id}")->with('status', $paid->getDescription());
            }
            
            
        }catch( \Exception $e ){
            DB::rollBack();
            return redirect("/pay/{$product->id}")->with( 'status', $e->getMessage() );
        }
        DB::commit();
        
        event( new CustomerRegisteredEvent( $customer, $license ) );
       
        
        return view('page.welcome', compact('customer', 'license'));
    }
    public function getOneYearDate()
    {
        $date = new \DateTime();
        $date->modify('+1 year');
        return $date->format('Y-m-d G:i:s');
    }
    public function index()
    {
        if( Gate::denies('is_admin')){
            return view('errors.401');
        }
        $customers = Customer::paginate(10);
        return view('customer.index', compact('customers'));
    }
    public function edit(Request $request, Customer $customer )
    {

    }
    public function update(Request $request, Customer $customer )
    {
        
    }
    public function show( Customer $customer )
    {
        
    }
    public function destroy(Customer $customer )
    {
        $customer->delete();
        return redirect('/customers')->with('status', "A customer has been deleted!");
    }
    
}

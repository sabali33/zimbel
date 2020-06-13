<?php

namespace App\Http\Controllers;

use App\License;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class LicenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if(Auth::user() && !Auth::user()->is_user_admin()){
            $licenses = License::whereHas('customer', function (Builder $query) {
                $query->where('customer_id', '=', Auth::user()->customer->id);
            } )->get();
        }else{
            $licenses = License::with(['customer', 'product'])->paginate(10);
        }
        
        return view('license.index', compact('licenses'));
    }
    public function store(Request $request)
    {
        $this->authorize('create', License::class );
        $license_key = $this->generateLicenseKey();
        $data = $this->validate_data($request);
        $data['license_key'] = $license_key;
        $created = License::create($data);
        return redirect("/licenses")->with("License with key {$created->license_key} has been created");
    }
    
    public function create()
    {
        $this->authorize('create', License::class );
        return view('license.create');
    }
    public function generateLicenseKey()
    {
        return Str::random();
    }
    public function validate_data($request)
    {
        return $request->validate([
            'customer_id' => "numeric",
            'product_id'  => 'numeric',
            'expiry_date' => 'string',
        ]);
    }
    public function destroy(License $license)
    {
        $this->authorize('view', $license );
        $deleted = $license->delete();
        return redirect("/licenses")->with("License key {$license->license_key} has been deleted");
    }
    
}

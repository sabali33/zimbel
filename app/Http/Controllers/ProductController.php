<?php

namespace App\Http\Controllers;

use Closure;
use App\Feature;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'searchApi']);
    }
    public function index()
    {
        $this->authorize('viewAny', Product::class );
        $products = Product::with('features')->paginate(5);
        return view('product.index', compact('products'));
    }
    public function create(Request $request)
    {
        $this->authorize('create', Product::class );
       return view('product.create');
    }
    public function store(Request $request)
    {
        $this->authorize('create', Product::class );
        return $data = $this->validate_data($request, function($data, $features, $media_ids){
            $product = Product::create($data);
            $product->features()->sync($features);
            if( !empty($media_ids) ){
                $product->syncMedia($media_ids, 'featured');
            }
            return [
                'redirect' => "/products/{$product->id}/edit",
                'message' =>  "A new product has been created!"
            ];
        });
        
    }
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }
    public function edit(Product $product)
    {
        $this->authorize('update', $product );
        return view('product.edit', compact('product'));
    }
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product );
        return $data = $this->validate_data($request, function($data, $features, $media_ids) use($product){
            $product->features()->sync($features);
            $updated = $product->update($data);
            if(count($media_ids) > 0 ){
                $product->syncMedia($media_ids, 'featured');
            }else{
                $product->detachMediaTags('featured');
            }
            return [
                'redirect' => "/products/{$product->id}/edit",
                'message'  => "Product saved!"
            ];
        });
    }
    public function destroy(Request $request, Product $product)
    {
        $this->authorize('delete', $product );

        $product->delete();
        return redirect("/products")->with("Product Deleted!");
    }
    public function validate_data(Request $request, Closure $callback){
        $data = $request->validate([
            'title' => 'string',
            'description' => 'string|nullable',
            'user_id' => 'numeric',
            'link'   => 'string',
            'features' => 'array',
            'attachment_ids' => 'string|nullable',
            'price' => 'numeric'
        ]);
        $features = isset($data['features']) ? $data['features'] : [];
        $media_ids = isset($data['attachment_ids']) ? explode(',', $data['attachment_ids'])  : [];
        unset($data['features']);
        unset($data['attachment_ids']);
        $response = $callback($data, $features, $media_ids );
        return redirect($response['redirect'])->with('status', $response['message']);
    }
    public function searchApi(Request $request)
    {
        return json_encode(Product::all()->toArray());
    }
}

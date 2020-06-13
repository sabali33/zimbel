<?php

namespace App\Http\Controllers;

use App\Feature;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FeatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $this->authorize('viewAny', Feature::class );
        $features = Feature::paginate(5);
        return view('feature.index', compact('features'));
    }
    public function create(Request $request)
    {
       return view('feature.create');
    }
    public function store(Request $request)
    {
        return $this->put($request, function($data, $attachment_ids){
            $feature = Feature::create($data);
            $feature->syncMedia($attachment_ids, 'featured');
            return [
                'redirect' => "/features/{$feature->id}/edit",
                'message'  => "A new feature has been created!"
            ];
        });
        
    }
    public function show(Feature $feature)
    {
        return view('feature.show', compact('feature'));
    }
    public function edit(Feature $feature)
    {
        $this->authorize('update', $feature);
        return view('feature.edit', compact('feature'));
    }
    public function update(Request $request, Feature $feature)
    {
        
        
        return $this->put($request, function($data, $attachment_ids) use($feature){
            $feature->update($data);
            $feature->syncMedia($attachment_ids, 'featured');
            return [
                'redirect' => "/features/{$feature->id}/edit",
                'message'  => "Featured saved!"
            ];
        });
        
    }
    public function destroy(Request $request, Feature $feature)
    {
        
        $feature->delete();
        return redirect("/features")->with("Feature Deleted!");
    }
    public function put(Request $request, $callback)
    {
        $data = $request->validate([
            'name' => 'string',
            'alias' => 'string|nullable',
            'product_id' => 'numeric',
            'attachment_ids' => 'string|nullable'
        ]);
        $attachment_ids = Str::contains($data['attachment_ids'], ',') ? explode(',', $data['attachment_ids']) : $data['attachment_ids'];
        
        unset($data['attachment_ids']);
        $response = $callback( $data, $attachment_ids );
        
        return redirect($response['redirect'])->with('status', $response['message']);
    }
}

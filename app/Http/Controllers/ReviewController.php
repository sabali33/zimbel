<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;

class ReviewController extends Controller
{
    protected $guarded = [];

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $reviews = Review::paginate(10);
        return  view('review.index', compact('reviews'));
    }
    public function create()
    {
        return view('review.create');
    }
    public function store(Request $request )
    {
        $data = $this->validate_data($request);
        try{
            $review = Review::create($data);
        }catch( QueryException $e ){
            return redirect('/reviews')->withErrors('You have already reviewed us');
        }
        

        return redirect("/reviews/{$review->id}/edit")->with('Review created');
    }
    public function show()
    {
        return view('review.show');
    }
    public function edit(Request $request, Review $review )
    {
        return view('review.edit', compact('review'));
    }
    public function update(Request $request, Review $review )
    {
        $data = $this->validate_data($request);
        $updated = $review->update($data);
        return redirect("/reviews/{$review->id}/edit")->with('Review updated');
    }
    public function destroy( Review $review )
    {
        $review->delete();
        return redirect("/reviews")->with('Review deleted');
    }
    public function validate_data(Request $request)
    {
        return $request->validate([
            'full_name' => 'string|required',
            'remark' => 'string|nullable',
            'rate'  => 'min:0|max:5',
            'ip_address' => 'ip',
            'title'  => 'string|nullable',
            'user_id' => 'numeric|nullable',
            'product_id' => 'numeric'
        ]);
    }
}

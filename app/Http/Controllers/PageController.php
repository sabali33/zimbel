<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PageController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index( Request $request )
    {
        if( Gate::denies('is_admin')){
            return view('errors.401');
        }
        $pages = Page::with('meta')->paginate(10);
        return view('page.index', compact('pages'));
    }

    public function show(Page $page)
    {

        return view('page.show', compact('page'));
    }
    public function create()
    {
        if( Gate::denies('is_admin')){
            return view('errors.401');
        }
        return view('page.create');
    }
    public function store( Request $request )
    {
        if( Gate::denies('is_admin')){
            return view('errors.401');
        }
        $data = $this->validate_data($request);
        $data['slug'] = Str::slug($data['title']);
        $page = Page::create($data);
        //save meta
        $meta = array_reduce($request->get('meta'), function($acc, $cur){
            if($cur[0] && $cur[1]){
                $acc[] = [
                    'meta_key' => Str::slug($cur[0]),
                    'meta_value' => $cur[1]
                ];
            }
            
            return $acc;
        }, []);
        $page->meta()->createMany($meta);
        return redirect("/pages/{$page->id}/edit")->with(' Page created');
    }
    public function edit( Request $request, Page $page )
    {
        if( Gate::denies('is_admin')){
            return view('errors.401');
        }
        return view('page.edit', compact('page'));
    }
    public function update( Request $request, Page $page )
    {
        if( Gate::denies('is_admin')){
            return view('errors.401');
        }
        $data = $this->validate_data($request);
        $updated = $page->update($data);
        
        if( $request->get('meta') ){ 
            $meta = $this->sanitize_meta($request->get('meta'));
            $old_meta = $page->meta->except(array_keys($meta));
            
            DB::transaction(function () use( $meta, $old_meta, $page ) {
                $old_meta->each(function($meta){
                    $meta->delete();
                });
                foreach( $meta as $id => $meta_item){
                    // $meta_item = [
                    //     'meta_key' => $meta_item_data[0],
                    //     'meta_value' => $meta_item_data[1]
                    // ];
                    //var_dump($meta_item);
                    $page->meta()->updateOrCreate($meta_item);
                }
            });
            
        }else{
            $page->meta->each(function($meta){ $meta->delete(); });
        }
        return redirect("/pages/{$page->id}/edit")->with('Page updated!');
    }
    public function destroy( Page $page )
    {
        $page->delete();
        return redirect('pages')->with('Page Deleted');
    }
    public function validate_data($request)
    {
        return $request->validate([
            'title' => 'string|required',
            'content' => 'string|nullable',
            'user_id' => 'numeric|required'
        ]);
    }
    public function sanitize_meta( $meta, $page=null )
    {
        if( !is_array($meta) ){
            return;
        }
        $meta_sanitize = [];
        foreach( $meta as $id => $meta_item ){
            if($meta_item[0] && $meta_item[1]){
                $meta_sanitize[$id] = [
                    'meta_key' => Str::slug($meta_item[0]),
                    'meta_value' => $meta_item[1]
                ];
            }
        }
        return $meta_sanitize;
    }
    
}

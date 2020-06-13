<?php

namespace App\Http\Controllers;


use MediaUploader;
use Plank\Mediable\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Gate::denies('is_admin')){
            return view('errors.401');
        }
        $media = Media::paginate('10');
        return view('media.index', \compact('media'));
        
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
        if( Gate::denies('is_admin')){
            return view('errors.401');
        }
        if($request->hasFile('files')){
            $files =  $request->file('files');
            $media_uploaded = [];
            foreach( $files as $file ){
                $media_uploaded[] = MediaUploader::fromSource( $file )
                    ->toDestination('uploads', 'blog')
                    ->upload();
            }
            
            return json_encode($media_uploaded);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy($media_id)
    {
        $delete = Media::where('id', '=', $media_id )->delete();
    }
    public function indexApi()
    {
        $media = Media::paginate(10);
        return json_encode($media->toArray());
    }
}

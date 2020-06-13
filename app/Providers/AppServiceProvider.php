<?php

namespace App\Providers;

use App\Time;
use App\User;
use App\Review;
use App\Feature;
use App\Product;
use App\Jobs\MakeRequest;
use App\Services\WorldPayGateWay;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::macro('getIpAddress', function () {
            if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                //ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                //ip pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }else{
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        });
        $this->app->singleton(WorldPayGateWay::class, function ($app) {
            return new WorldPayGateWay();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['feature.create', 'feature.edit'], function($view){
            $products = Product::all();
            $view->with('products', $products);
        });
        View::composer(['product.form'], function($view){
            $features = Feature::all();
            $view->with('features', $features );
        });
        View::composer(['page.form'], function($view){
            $users = User::all();
            $view->with('users', $users );
        });
        View::composer(['review.form'], function($view){
            $ip = Collection::getIpAddress();
            $products = Product::all();
            $view->with( compact('ip', 'products' ) );
        });
        
        View::composer(['landing', 'home'], function ($view) {
            $product = Product::first();
            $view->with(compact('product'));
        });
        $this->app->bindMethod(MakeRequest::class.'@handle', function ($job, $app) {
            return $job->handle($app->make(RemoteRequestProcessor ::class), $app->make(Time::class));
        });
        
    }
}

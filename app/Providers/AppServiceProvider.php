<?php

namespace App\Providers;
use App\User;
use App\Product;
use App\Mail\UserCreated;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        User::created(function($user){
            Mail::to($user)->send(new UserCreated());
        });

        Product::updated(function($product){
            if($product->quantity ==0 && $product->estaDisponible()) {
                $product->status = Product::PRODUCTO_NO_DISPONIBLE;

                $product-> save();
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

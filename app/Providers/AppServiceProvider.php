<?php

namespace App\Providers;

use App\User;
use App\Product;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use Illuminate\Support\Facades\Mail;
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

        // Send a verification email to user when created
        User::created(function($user) {
            retry(5, function() use ($user) {
                Mail::to($user->email)->send(new UserCreated($user));  
            }, 100);
        });

        // Send a verification email to user when email changed
        User::updated(function($user) {
            retry(5, function() use ($user) {
                if ($user->isDirty('email')) {
                    Mail::to($user->email)->send(new UserMailChanged($user));
                }
            }, 100);
        });

        // Update a product status when a product is updated
        Product::updated(function($product) {
            if ($product->quantity == 0 && $product->isAvailable()) {
                $product->status = Product::UNAVAILABLE_PRODUCT;

                $product->save();
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

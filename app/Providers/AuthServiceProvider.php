<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Buyer;
use App\Policies\BuyerPolicy;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Buyer::class => BuyerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Laravel/Passport service providers
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();

        // Scopes
        Passport::tokensCan([
            'purchase-product' => 'Create a new transaction for a speciic product',
            'manage-products'   => 'Create, read, update and delete a product (CRUD)',
            'manage-account'   => 'Read your account data, id, name, email, if verified. and if admin
                (cannot read password), modify your account data (email and password).
                cannot delete your account',
            'read-general'     => 'Read general information like purchasing categories, purchased products, selling products, selling categories and your transactions (purchases and sales)',
        ]);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
	    if (config('app.env') === 'production') {
		    \URL::forceScheme('https');
	    }
	    view()->composer('*', function ($view) {
		    $user = Auth::user();
		    $max_exp = \App\Exp::where('exp_level', $user['user_level'] + 1)->first();
		    $user['user_exp_max'] = $max_exp['exp_up'];
		    //...with this variable
		    $view->with('user', $user);
	    });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class MemberServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /*
        The custom validator Closure receives four arguments: the name of the $attribute being validated,
        the $value of the attribute, an array of $parameters passed to the rule,
        and the Validator instance.
        */
        Validator::extend('alpha_spaces', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[\pL\s]+$/u', $value);
        });
    }

    public function register()
    {
        //
    }
}

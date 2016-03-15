<?php

/*
Assuming you use Laravel 5.2: You'll need to use the web middleware if you need session state,
CSRF protection, and more. (like the global in 5.1)
*/
Route::group(['middleware' => ['web']], function () {
    Route::resource('api/v1/member', 'MemberController');
    
    Route::get('/', ['as' => 'member_list', function() {
        return view('member.index');
    }]);

    Route::get('/create', array(
        'as'    => 'member_create',
        'uses'  => 'MemberController@create'
    ));

    Route::get('/{id}/edit', array(
        'as'    => 'member_edit',
        'uses'  => 'MemberController@edit'
    ));
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});

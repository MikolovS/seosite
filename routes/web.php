<?php
declare( strict_types = 1 );

Route::group(['middleware' => ['setSiteConfigs']], function(){
	Route::get('/', function () {
		dd(111);
		return view('welcome');
	});
});

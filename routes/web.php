<?php
declare( strict_types = 1 );

Route::group(['middleware' => ['setSiteConfigs']], function () {
	Route::get('/', function () {
		return view('welcome');
	});
});
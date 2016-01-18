<?php

if ( str_contains( app()->version(), '5.2.' ) ){
	Route::group(['middleware' => 'web'], function () {
		Route::resource('amazo', 'Smarch\Amazo\Controllers\AmazoController');
	});
} else {
	Route::resource('amazo', 'Smarch\Amazo\Controllers\AmazoController');
}
<?php
Route::group( [
	'middleware'=> config('amazo.route.middleware'),
	'prefix'	=> config('amazo.route.prefix'),
	'as'		=> config('amazo.route.as') ], function () {
		Route::resource('amazo', 'Smarch\Amazo\Controllers\AmazoController',
			['names' => [
	    		'create'	=> 'create',
	    		'destroy'	=> 'destroy',
	    		'edit'		=> 'edit',
	    		'index'		=> 'index',
	    		'show'		=> 'show',
	    		'store'		=> 'store',
	    		'update'	=> 'update'
				]
			]
		);
		Route::get('amazo/{id}/mods', 'Smarch\Amazo\Controllers\AmazoController@modifiers')->name('mods');
		Route::post('amazo/{id}/mods', 'Smarch\Amazo\Controllers\AmazoController@updateModifiers')->name('mods');
		Route::delete('amazo/{id}/mods', 'Smarch\Amazo\Controllers\AmazoController@destroyModifier')->name('destroy.mod');
	}
);
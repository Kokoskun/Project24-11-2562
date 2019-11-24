<?php
Route::prefix('v1/')->group(function(){
	Route::get('restaurants', 'API\V1\RestaurantController@list');
});
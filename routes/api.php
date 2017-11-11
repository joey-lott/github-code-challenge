<?php

Route::get('/user', "Api\UserSearchController@runSearch");
Route::get('/followers', "Api\FollowersController@fetchFollowers");

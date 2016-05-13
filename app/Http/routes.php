<?php

Route::get('/', 'ProductController@getNewProduct');

Route::post('/product/create', 'ProductController@postNewProduct');
Route::post('/product/create/imageupload', 'ProductController@postNewProductImageUpload');
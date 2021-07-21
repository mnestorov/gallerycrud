<?php

/**
 * Front-end routes
 */
Route::group(['prefix' => 'gallery'], function () {
    Route::get('/', ['uses' => '\SmartyStudio\GalleryCrud\app\Http\Controllers\GalleryController@index']);
    Route::get('/{gallery}/{subs?}', ['as' => 'view-gallery', 'uses' => '\SmartyStudio\GalleryCrud\app\Http\Controllers\GalleryController@show'])
        ->where(['gallery' => '^((?!admin).)*$', 'subs' => '.*']);
});

// Glide path
Route::get('/'.config('smartystudio.gallerycrud.glide_path', 'images').'/{path}', 'SmartyStudio\GalleryCrud\app\Http\Controllers\ImageController@show')->where('path', '.+');

/**
 * Admin routes
 */
Route::group([
    'namespace' => 'SmartyStudio\GalleryCrud\app\Http\Controllers\Admin',
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    Route::crud('gallery', 'GalleryCrudController');
});
<?php

// Grid Map Controller backend
Route::get(ADM_URI.'/(:bundle)', function()
{
    return Controller::call('gridmap::backend.gridmap@index');
});

Route::put(ADM_URI.'/(:bundle)', function()
{
    return Controller::call('gridmap::backend.gridmap@update');
});


// Grid Map Controller frontend
$map_slug_handler = Config::get('settings::core.gridmap_map_slug');
Route::get($map_slug_handler, function()
{
    return Controller::call('gridmap::frontend.gridmap@index');
});

Route::get('maptile/coords/(:any?)/size/(:any?)/scopeid/(:any?)/overlays/(:any?)/user/(:any?)', function($coordenate, $size, $scope_id, $overlays, $user)
{
    return Controller::call('gridmap::frontend.gridmap@maptile', array($coordenate, $size, $scope_id, $overlays, $user));
});

Route::get('regioninfo/coords/(:any?)/scopeid/(:any?)/user/(:any?)', function($coordenate, $scope_id, $user)
{
    return Controller::call('gridmap::frontend.gridmap@regioninfo', array($coordenate, $scope_id, $user));
});

Route::get('search_by_name', function()
{
    return Controller::call('gridmap::frontend.gridmap@search_by_name', array(null, null));
});

Route::get('search_by_name/scope_id/(:any?)/name/(:any?)', function($scope = null, $name = null)
{
    return Controller::call('gridmap::frontend.gridmap@search_by_name', array($scope, $name));
});
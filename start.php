<?php

/*
|--------------------------------------------------------------------------
| Opensim Database
|--------------------------------------------------------------------------
|
| Load OpenSim database
|
*/
$db_is_ready = Config::get('settings::core.passes_db_settings');

if((bool)$db_is_ready)
{
    $opensim_db_config = Config::get('opensim::database.connections.default');
    Config::set('database.connections.opensim', $opensim_db_config);
}
<?php

class Gridmap_Schema_Task {

    public function __construct()
    {
        Bundle::register('settings');
        Bundle::start('settings');

        Bundle::register('modules');
        Bundle::start('modules');

        Bundle::register('gridmap');
        Bundle::start('gridmap');
    }

    public function install()
    {
        $module = Modules\Model\Module::where_slug('gridmap')->first();

        $gridmap_map_slug = array(
            'title'       => 'Grid Map Slug', 
            'slug'        => 'gridmap_map_slug', 
            'description' => 'The URI of the grid map', 
            'type'        => 'text', 
            'default'     => 'grid_map', 
            'value'       => 'grid_map', 
            'options'     => '', 
            'class'       => 'settings', 
            'section'     => 'main',
            'validation'  => 'alpha_dash', 
            'is_gui'      => '1', 
            'module_slug' => 'gridmap', 
            'module_id'   => $module->id, 
            'order'       => '999', 
        );
        $gridmap_map_slug = Settings\Model\Setting::create($gridmap_map_slug);

        $gridmap_grid_asset_url = array(
            'title'       => 'Grid Asset URL', 
            'slug'        => 'gridmap_grid_asset_url', 
            'description' => 'The grid assets server url', 
            'type'        => 'text', 
            'default'     => '', 
            'value'       => '', 
            'options'     => '', 
            'class'       => 'settings', 
            'section'     => 'main',
            'validation'  => 'required', 
            'is_gui'      => '1', 
            'module_slug' => 'gridmap', 
            'module_id'   => $module->id, 
            'order'       => '999', 
        );
        $gridmap_grid_asset_url = Settings\Model\Setting::create($gridmap_grid_asset_url);

        $gridmap_map_initial_position_x = array(
            'title'       => 'Map X Initial Coordenate', 
            'slug'        => 'gridmap_map_initial_position_x', 
            'description' => 'The initial x cordenate to be used when map first loads', 
            'type'        => 'text', 
            'default'     => '7000', 
            'value'       => '7000', 
            'options'     => '', 
            'class'       => 'settings', 
            'section'     => 'main',
            'validation'  => 'required|integer', 
            'is_gui'      => '1', 
            'module_slug' => 'gridmap', 
            'module_id'   => $module->id, 
            'order'       => '999', 
        );
        $gridmap_map_initial_position_x = Settings\Model\Setting::create($gridmap_map_initial_position_x);

        $gridmap_map_initial_position_y = array(
            'title'       => 'Map Y Initial Coordenate', 
            'slug'        => 'gridmap_map_initial_position_y', 
            'description' => 'The initial y cordenate to be used when map first loads', 
            'type'        => 'text', 
            'default'     => '7000', 
            'value'       => '7000', 
            'options'     => '', 
            'class'       => 'settings', 
            'section'     => 'main',
            'validation'  => 'required|integer', 
            'is_gui'      => '1', 
            'module_slug' => 'gridmap', 
            'module_id'   => $module->id, 
            'order'       => '999', 
        );
        $gridmap_map_initial_position_y = Settings\Model\Setting::create($gridmap_map_initial_position_y);
    }

    public function uninstall()
    {
        //
        // REMOVE GRIDMAP
        // 
        $settings = Settings\Model\Setting::where_module_slug('gridmap')->get();
        
        if(isset($settings) and !empty($settings))
        {
            foreach ($settings as $setting) 
            {
                $setting->delete();
            }
        }
    }

    public function __destruct()
    {
        Bundle::disable('settings');
        Bundle::disable('modules');
        Bundle::disable('gridmap');
    }
}
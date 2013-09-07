<?php

class Gridmap_Frontend_Gridmap_Controller extends Public_Controller {
    
    public function get_index()
    {
        $this->data['meta_title']       = 'Grid Map';
        $this->data['meta_description'] = 'Full map of grid';
        $this->data['meta_keywords']    = 'grid, map';

        return $this->theme->render('gridmap::frontend.index', $this->data);
    }

    public function get_maptile($coordenate, $size, $scope_id, $overlays, $user)
    {
        $db_is_ready = Config::get('settings::core.passes_db_settings');

        if((bool)$db_is_ready)
        {
            $cordenates = array_filter(explode('x', $coordenate));
            
            $x_coordenate = $cordenates['1']*256;
            $y_coordenate = $cordenates['2']*256;
            
            $region = Opensim\Model\Os\Region::where_locX($x_coordenate)->where_locY($y_coordenate)->first();
            
            if(isset($region->regionname))
            {
                $this->convert_map_image($region->regionmaptexture, $size);
                $this->data['region_name']             = $region->regionname;
                $this->data['region_coordenate']       = $cordenates['1'].','.$cordenates['2'];
                $this->data['region_map_texture']      = $region->regionmaptexture.'-'.$size.'x'.$size.'.jpg';
                $this->data['map_tile_size']           = $size;
                
                return View::make('gridmap::frontend.partials.maptile', $this->data)->render();
            }
            else
            {
                $this->data['region_coordenate'] = $cordenates['1'].','.$cordenates['2'];

                return View::make('gridmap::frontend.partials.maptile', $this->data)->render();
            }
        }
        else
        {
            Log::error('Error trying to load map-tile. Opensim Database settings must be configured');
        }
    }

    public function get_regioninfo($coordenate, $scope_id, $user)
    {
        $db_is_ready = Config::get('settings::core.passes_db_settings');

        if((bool)$db_is_ready)
        {
            $cordenates = array_filter(explode('x', $coordenate));
            
            $x_coordenate = $cordenates['1']*256;
            $y_coordenate = $cordenates['2']*256;
            
            // $region_details = Opensim\Model\Os\Region::where_locX($x_coordenate)->where_locY($y_coordenate)->first();
            
            $region_details = DB::connection('opensim')->table('regions')
                ->where_locX($x_coordenate)
                ->where_locY($y_coordenate)
                ->left_join('UserAccounts', 'regions.owner_uuid', '=', 'UserAccounts.PrincipalID')->first();


            $html_string = '';

            if(isset($region_details) and !empty($region_details))
            {
                // $user_account = Opensim\Model\Os\UserAccount::where_PrincipalID($region_details->owner_uuid)->first();
                //if(isset($user_account) and !empty($user_account))

                if(isset($region_details->firstname))
                {
                    $html_string .= 'Region: '.$region_details->regionname.'<br>';
                    $html_string .= 'Owner: '.$region_details->firstname.' '.$region_details->lastname.'<br>';
                    $html_string .= 'Location: '.($x_coordenate / 256).','.($y_coordenate / 256).'<br>';
                }
                else
                {
                    $html_string .= 'Region: '.$region_details->regionname.'<br>';
                    $html_string .= 'Owner: Unknown <br>';
                    $html_string .= 'Location: '.($x_coordenate/256).','.($y_coordenate/256).'<br>';
                }
            }

            return $html_string;
        }

        return 'Opensim not set';
    }

    public function get_search_by_name($scope, $name)
    {
        $db_is_ready = Config::get('settings::core.passes_db_settings');

        if((bool)$db_is_ready)
        {
            if(!isset($scope) and !isset($name))
            { 
                $this->data['uuid_zero'] = Opensim\UUID::ZERO;
                return View::make('gridmap::frontend.partials.search_form', $this->data);
            }
            else
            {
                $this->data['regions'] = Opensim\Model\Os\Region::where('regionName', 'like', $name.'%')->take(10)->get();

                return View::make('gridmap::frontend.partials.search_result', $this->data);
            }
        }
    }

    private function convert_map_image($region_texture_uuid, $size)
    {
        $geom = $size.'x'.$size;

        $path = path('public').'media/gridmap/img/tmp_maptiles/';

        if( !file_exists($path))
        {
            @mkdir($path , 0777, true );
        }

        $asset_url = rtrim(Config::get('settings::core.gridmap_grid_asset_url'), '/');

        $url = $asset_url.'/'.$region_texture_uuid.'/data';
        
        if( !file_exists($path."$region_texture_uuid-$geom.jpg"))
        {
            copy($url, $path."$region_texture_uuid.j2k");
            exec("j2k_to_image -i $path$region_texture_uuid.j2k -o $path$region_texture_uuid.tga");
            exec("convert -scale $size $path$region_texture_uuid.tga $path$region_texture_uuid-$geom.jpg");
            @unlink("$path$region_texture_uuid.j2k");
            @unlink("$path$region_texture_uuid.tga");
        }
    }
}
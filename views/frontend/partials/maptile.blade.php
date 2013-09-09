<?php 
// the "\n" in the end of lines is nedded sice the 
// js file split the information based on "\n". jquery.map.js line 381
// needs to be fixed!
?>
@if(isset($region_name))
    <span class="map-tooltip">{{ $region_coordenate }}</span>{{ "\n" }}
    {{ Config::get('gridmap::settings.tile_cache_path') .'/'. $region_map_texture }}{{ "\n" }}

    @if($map_tile_size > 64)
    <input class="data" type="hidden" value="no" />
    <p class="data map-regionname">{{ $region_name }}</p>
    @endif
@else
    <span class="map-tooltip">{{ $region_coordenate }}</span>{{ "\n" }}
    bundles/gridmap/img/waterback.jpg{{ "\n" }}

@endif
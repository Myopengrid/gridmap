<?php themes\add_asset('styles.css', 'mod: gridmap/css', array(), 'page') ?>
<?php themes\add_asset('map.css', 'mod: gridmap/css', array(), 'page') ?>
<?php themes\add_asset('jquery.tooltip.css', 'mod: gridmap/css', array(), 'page') ?>
<?php themes\add_asset('jquery.contextMenu.css', 'mod: gridmap/css', array(), 'page') ?>
<?php themes\add_asset('jquery-ui-1.7.3.custom.css', 'mod: gridmap/css/overcast', array(), 'page') ?>


<?php themes\add_asset('jquery-ui-1.8.23.min.js', 'mod: gridmap/js', array('jquery'), 'footer') ?>
<?php themes\add_asset('jquery.corner.js', 'mod: gridmap/js', array('jquery'), 'footer') ?>
<?php themes\add_asset('jquery.tools.min.js', 'mod: gridmap/js', array('jquery'), 'footer') ?>
<?php themes\add_asset('jquery.bgiframe.js', 'mod: gridmap/js', array('jquery'), 'footer') ?>
<?php themes\add_asset('jquery.delegate.js', 'mod: gridmap/js', array('jquery'), 'footer') ?>
<?php themes\add_asset('jquery.tooltip.js', 'mod: gridmap/js', array('jquery'), 'footer') ?>
<?php themes\add_asset('jQuery_mousewheel_plugin.js', 'mod: gridmap/js', array('jquery'), 'footer') ?>
<?php themes\add_asset('jquery.rightClick.js', 'mod: gridmap/js', array('jquery'), 'footer') ?>
<?php themes\add_asset('jquery.contextMenu.js', 'mod: gridmap/js', array('jquery'), 'footer') ?>
<?php themes\add_asset('jquery.map.js', 'mod: gridmap/js', array('jquery'), 'footer') ?>
<?php themes\add_asset('gridmap.js', 'mod: gridmap/js', array('jquery'), 'footer') ?>

<script type="text/javascript">
  var GRIDMAP_INITIAL_X_COORDENATE = "{{Config::get('settings::core.gridmap_map_initial_position_X')}}";
  var GRIDMAP_INITIAL_Y_COORDENATE = "{{Config::get('settings::core.gridmap_map_initial_position_y')}}";
</script>

<div class="row">
    
    <div style="margin-bottom:15px;">
        <a class="btn btn-mini btn-primary" id="searchcoords">Search by coordinates</a> 
        <a class="btn btn-mini btn-primary" id="searchname">Search by name</a>
    </div>

    <div id="map1" style="width: 100%; height: 560px; "></div>

    <ul id="infomenu" class="contextMenu">
        <li id="info" class="info"><a href="#info">Details</a></li>
    </ul>
    
    <div id="infodialog"></div>
    
    <div id="searchbycoords" style="display: none;">
        <div style="width: 40%; float: left; padding-left: 20px;">X Coordinate</div>
        <div style="width: 40%; float: left; padding-left: 20px;">
            <input style="width: 98%; border: solid 1px black; margin: 2px;" type="text" id="xcoord" />
        </div>
        <div style="width: 40%; float: left; padding-left: 20px; clear: both;">Y Coordinate</div>
        <div style="width: 40%; float: left; padding-left: 20px;">
            <input style="width: 98%; border: solid 1px black; margin: 2px;" type="text" id="ycoord" />
        </div>

        <div style="clear: both">&nbsp;</div>
    </div>
    <div id="searchbyname"></div>
</div>

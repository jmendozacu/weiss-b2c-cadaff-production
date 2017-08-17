<?php
// [gmap]
function shortcode_gmap($atts, $content=null) {
    global $trego_vars;

    $gmapHTML = '';

	if(empty($trego_vars['gmap_lat'])){
		$trego_vars['gmap_lat'] = "";
	}
	if(empty($trego_vars['gmap_long'])){
		$trego_vars['gmap_long'] = "";
	}
	if(empty($trego_vars['gmap_address'])){
		$trego_vars['gmap_address'] = "";
	}
	if(empty($trego_vars['gmap_zoom'])){
		$trego_vars['gmap_zoom'] = "";
	}

	extract(shortcode_atts(array(
        'height' => '300px',
        'margin_bottom'    => '',
        'lat'  => $trego_vars['gmap_lat'],
        'long' => $trego_vars['gmap_long'],
        'addr' => $trego_vars['gmap_address'],
        'zoom' => $trego_vars['gmap_zoom'],
        'type' => 'roadmap'
    ), $atts));

    if (is_int($height)) $height .= 'px';

    $api_key = $trego_vars['gmap_key'];

    $gmap_id = 'gmap_' . rand();
    $gmap_marker = (!empty($trego_vars['marker'])) ? $trego_vars['marker'] : get_template_directory_uri() . '/images/marker.png';
    if ($addr != '' ) {
        $gmap_url = "http://maps.googleapis.com/maps/api/geocode/json?address=". urlencode($addr) . "&sensor=false";
        $raw = @file_get_contents($gmap_url);
        $gmap_data = json_decode($raw);
        if (@$gmap_data->results) {
            $lat = $gmap_data->results[0]->geometry->location->lat;
            $lng = $gmap_data->results[0]->geometry->location->lng;
        }
    }
    ob_start();
    ?> 
    
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false<?php echo !empty($api_key)?('&key='.$api_key):''; ?>"></script>
    <script type="text/javascript">
    //<![CDATA[
    var store = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $long ?>);
    var marker;
    var map;

    function initialize() {
        var mapOptions = {
            zoom: <?php echo $zoom ?>,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: store,
            scrollwheel: false
        };

        map = new google.maps.Map(document.getElementById('<?php echo $gmap_id ?>'), mapOptions);

        marker = new google.maps.Marker({
            map: map,
            draggable: false,
            animation: google.maps.Animation.DROP,
            position: store,
            icon: '<?php echo $gmap_marker ?>'
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
    google.maps.event.addDomListener(window, 'resize', initialize);
    //]]>
    </script>
    <?php
        $style = "";
        if($height){
            $style .= 'height: ' . $height . ';';
        }
        if($margin_bottom){
            $style .= 'margin-bottom: ' . $margin_bottom . ';';
        }
        if($style != ""){
            $style = ' style="' . $style . '"';
        }
    ?>
    <div id="<?php echo $gmap_id; ?>" class="gmap" <?php echo $style; ?>></div>

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode('gmap', 'shortcode_gmap');

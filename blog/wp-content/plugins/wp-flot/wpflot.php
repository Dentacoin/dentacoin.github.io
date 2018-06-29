<?php
/*
Plugin Name: WP Flot
Plugin URI: http://www.youssouhaagsman.nl/wpflot/
Description: Shortcodes for Flot
Version: 0.2.2
Author: Youssou Haagsman
Author URI: http://www.youssouhaagsman.nl
License: GPLv2
*/

/*  Copyright 2015 Youssou Haagsman

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Script
	
load_plugin_textdomain('wpflot', false, basename( dirname( __FILE__ ) ) . '/languages' );
	
function flot_scripts() {
	
	$flot = get_post_meta( get_the_ID(), 'flot', true );
	
	if($flot == 'yes' || is_home() || is_category() || is_tag() || is_archive()) {
	
		wp_register_script('flot', plugins_url( 'js/jquery.flot.all.min.js', __FILE__ ) ,array('jquery'));
		
		wp_enqueue_script('flot');
		
		function legendstyle() {
		
			$legendstyle = <<<STYLE
<style type="text/css">
.legend table {
	width: auto;
	border: 0px;
}

.legend tr {
	border: 0px;
}
.legend td {
	padding: 5px;
	font-size: 12px;
	border: 0px;
}
</style>
STYLE;
		
		echo $legendstyle;
		}
		
		add_action('wp_head', 'legendstyle');
		
	}
	
	}

add_action('wp_enqueue_scripts', 'flot_scripts');

// Shortcodes

function linechart_shortcode( $atts, $content ) {
	extract( shortcode_atts( array(
		'name' => 'Chart',
		'height' => '400px',
		'width' => '100%',
		'points' => 'true',
		'fill' => 'false',
		'steps' => 'false',
		'maxx' => 'null',
		'maxy' => 'null',
		'minx' => 'null',
		'miny' => 'null',
		'legend' => 'true'
	), $atts ) );
		
	static $number = 0;
	$number++;
	
	$content = strip_tags($content);
		
	if (get_post_meta( get_the_ID(), 'flot', true ) !== 'yes')
	{
	update_post_meta( get_the_ID(), 'flot', 'yes');
	}
		
	return <<<HTML
	<div id="plotarea$number" style="height: {$height}; width: {$width};">
	</div>
	<script type="text/javascript">
jQuery(document).ready(function($){
	var dataseries$number = [
		$content
	];

	var options$number = {
			series: {
				points: {
					show: {$points},
					radius: 3
				},
				lines: {
					show: true,
					fill: {$fill},
					fillColor: { colors: [ { opacity: 0.6 }, { opacity: 0.3 } ] },
					steps: {$steps},
					lineWidth: 1
				},
			},
			legend: {
				show: {$legend},
				backgroundOpacity: 0.7
			},
			grid: {
				backgroundColor: null
			},
			yaxis: {
				min: {$miny},
				max: {$maxy}
			},
			xaxis: {
				min: {$minx},
				max: {$maxx}
			},
	};
	
	var plotarea$number = $("#plotarea$number");  
	var plot$number = $.plot( plotarea$number , dataseries$number, options$number ); 

});
</script>
HTML;
}	

function barchart_shortcode( $atts, $content ) {
	extract( shortcode_atts( array(
		'name' => 'Chart',
		'height' => '400px',
		'width' => '100%',
		'fill' => 'true',
		'maxx' => 'null',
		'maxy' => 'null',
		'minx' => 'null',
		'miny' => 'null',
		'legend' => 'true',
		'horizontal' => 'false'
	), $atts ) );
		
	static $number = 0;
	$number++;
	
	if (get_post_meta( get_the_ID(), 'flot', true ) !== 'yes')
	{
	update_post_meta( get_the_ID(), 'flot', 'yes');
	}
	
	$content = strip_tags($content);
		
	return <<<HTML
	<div id="bararea$number" style="height: {$height}; width: {$width};">
	</div>
	<script type="text/javascript">
jQuery(document).ready(function($){
	var bardataseries$number = [
		$content
	];

	var baroptions$number = {
			series: {
				bars: {
					show: true,
					align: "center",
					barWidth: 0.5,
					horizontal: {$horizontal}
				}
			},
			legend: {
				show: {$legend},
				backgroundOpacity: 0.7
			},
			grid: {
				backgroundColor: null
			},
			yaxis: {
				min: {$miny},
				max: {$maxy}
			},
			xaxis: {
				min: {$minx},
				max: {$maxx}
			},
	};
	
	var bararea$number = $("#bararea$number");  
	var barplot$number = $.plot( bararea$number , bardataseries$number, baroptions$number ); 

});
</script>
HTML;
}

function piechart_shortcode( $atts, $content ) {
	extract( shortcode_atts( array(
		'name' => 'Chart',
		'height' => '400px',
		'width' => '100%',
		'legend' => 'false',
		'donut' => '0',
		'combine' => '0'
	), $atts ) );
		
	static $number = 0;
	$number++;
	
	if (get_post_meta( get_the_ID(), 'flot', true ) !== 'yes')
	{
	update_post_meta( get_the_ID(), 'flot', 'yes');
	}
	
	$content = strip_tags($content);
	
	$other = __('Other','wpflot');
		
	return <<<HTML
	<div id="piearea$number" style="height: {$height}; width: {$width};">
	</div>
	<script type="text/javascript">
jQuery(document).ready(function($){
	var pie_dataseries$number = [
		$content
	];

	var options$number = {
			series: {
				pie: {
					show: true,
					innerRadius: {$donut},
					combine: {
						color: '#999',
						threshold: {$combine},
						label: '{$other}'
					},
				}
			},
			legend: {
				show: {$legend},
				backgroundOpacity: 0.7
			},
			grid: {
				backgroundColor: null
			}
	};
	
	var piearea$number = $("#piearea$number");  
	var pieplot$number = $.plot( piearea$number , pie_dataseries$number, options$number ); 

});
</script>
HTML;
}

add_shortcode( 'linechart', 'linechart_shortcode' );
add_shortcode( 'piechart', 'piechart_shortcode' );
add_shortcode( 'barchart', 'barchart_shortcode' );

add_action( 'admin_init', function() {
	if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
	/*	add_action( 'admin_notices', function(){
			if ( current_user_can( 'activate_plugins' ) ) {
				echo '<div class="error message"><p>__( 'It is recommended to enable Shortcake to make adding shortcodes easier.', 'wpflot' ),</p></div>';
			}
			}); */
		return;
	}
	else {
		shortcode_ui_register_for_shortcode(
				'linechart',
				array(
					'label' => __( 'Linechart', 'wpflot' ),
					'listItemImage' => 'dashicons-chart-line',
					'inner_content' => array(
						'label' => __( 'Data', 'wpflot' ),
					),
					'attrs' => array(
						array(
							'label' => __( 'Name', 'wpflot' ),
							'attr'  => 'name',
							'type'  => 'text',
						),
						array(
							'label' => __( 'Height', 'wpflot' ),
							'attr'  => 'height',
							'type'  => 'text',
								'meta' => array(
								'placeholder' => '400px',
							),

						),
						array(
							'label' => __( 'Width', 'wpflot' ),
							'attr'  => 'width',
							'type'  => 'text',
								'meta' => array(
								'placeholder' => '100%',
							),
						),
						array(
							'label' => __( 'Points', 'wpflot' ),
							'attr'  => 'points',
							'type'  => 'checkbox',
						),
						array(
							'label' => __( 'Fill', 'wpflot' ),
							'attr'  => 'fill',
							'type'  => 'checkbox',
						),
						array(
							'label' => __( 'Steps', 'wpflot' ),
							'attr'  => 'steps',
							'type'  => 'checkbox',
						),
						array(
							'label' => __( 'Legend', 'wpflot' ),
							'attr'  => 'steps',
							'type'  => 'checkbox',
						),
						array(
							'label' => __( 'Maximum value X-axis', 'wpflot' ),
							'attr'  => 'maxx',
							'type'  => 'number',
						),
						array(
							'label' => __( 'Maximum value Y-axis', 'wpflot' ),
							'attr'  => 'maxy',
							'type'  => 'number',
						),
						array(
							'label' => __( 'Minimum value X-axis', 'wpflot' ),
							'attr'  => 'minx',
							'type'  => 'number',
						),
						array(
							'label' => __( 'Minimum value Y-axis', 'wpflot' ),
							'attr'  => 'miny',
							'type'  => 'number',
						),
					),
				)
			);
			
			shortcode_ui_register_for_shortcode(
				'barchart',
				array(
					'label' => __( 'Barchart', 'wpflot' ),
					'listItemImage' => 'dashicons-chart-bar',
					'inner_content' => array(
						'label' => 'Data',
					),
					'attrs' => array(
						array(
							'label' => __( 'Height', 'wpflot' ),
							'attr'  => 'height',
							'type'  => 'text',
							'meta' => array(
								'placeholder' => '400px',
							),
						),
						array(
							'label' => __( 'Width', 'wpflot' ),
							'attr'  => 'width',
							'type'  => 'text',
								'meta' => array(
								'placeholder' => '100%',
							),
						),
						array(
							'label' => __( 'Horizontal', 'wpflot' ),
							'attr'  => 'horizontal',
							'type'  => 'checkbox',
						),
						array(
							'label' => __( 'Legend', 'wpflot' ),
							'attr'  => 'steps',
							'type'  => 'checkbox',
						),
						array(
							'label' => __( 'Maximum value X-axis', 'wpflot' ),
							'attr'  => 'maxx',
							'type'  => 'number',
						),
						array(
							'label' => __( 'Maximum value Y-axis', 'wpflot' ),
							'attr'  => 'maxy',
							'type'  => 'number',
						),
						array(
							'label' => __( 'Minimum value X-axis', 'wpflot' ),
							'attr'  => 'minx',
							'type'  => 'number',
						),
						array(
							'label' => __( 'Minimum value Y-axis', 'wpflot' ),
							'attr'  => 'miny',
							'type'  => 'number',
						),
					),
				)
			);
			
			shortcode_ui_register_for_shortcode(
				'piechart',
				array(

					'label' => __( 'Piechart', 'wpflot' ),
					'listItemImage' => 'dashicons-chart-pie',
					'inner_content' => array('label' => __( 'Data', 'wpflot' )),
					'attrs' => array(
						array(
							'label' => __( 'Height', 'wpflot' ),
							'attr'  => 'height',
							'type'  => 'text',
								'meta' => array(
								'placeholder' => '400px',
							),
						),
						array(
							'label' => __( 'Width', 'wpflot' ),
							'attr'  => 'width',
							'type'  => 'text',
								'meta' => array(
								'placeholder' => '100%',
							),
						),
						array(
							'label' => __( 'Legend', 'wpflot' ),
							'attr'  => 'steps',
							'type'  => 'checkbox',
						),
						array(
							'label' => __( 'Doughnut hole', 'wpflot' ),
							'attr'  => 'donut',
							'type'  => 'number',
								'meta' => array(
								'placeholder' => '0',
							),
							'description' => __( 'The size of the doughnut hole, as a number between 0 and 1.', 'wpflot' )
						),
					),
				)
			);
			
		}

} );

add_filter( 'no_texturize_shortcodes', 'wpf_no_wptexturize' );
function wpf_no_wptexturize($shortcodes){
    $shortcodes = array('linechart', 'piechart', 'barchart');
    return $shortcodes;
};

?>
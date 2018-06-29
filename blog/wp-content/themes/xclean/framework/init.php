<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

 /**
 *
 * Initial all the basic files with functions.
 *
 */


get_template_part( 'framework/woocommerce' );
get_template_part( 'framework/template-tags' );
get_template_part( 'framework/widgets-init' );
get_template_part( 'framework/tgm-plugin-activation' );
get_template_part( 'framework/functions' );
get_template_part( 'framework/customizer' );
?>
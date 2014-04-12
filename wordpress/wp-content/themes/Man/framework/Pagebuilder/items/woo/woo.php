<?php

function blox_parse_woo_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'type' => 'recent_products',
                'per_page' => '12',
                'columns' => '4',
                'orderby' => '',
                'extra_class' => '',
                'skin' => 'default'
                    ), $atts));

    $result = $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';

    $result .= "[$type per_page='$per_page' columns='$columns' ".($orderby=='1' ? "orderby='date' order='desc'" : "")."]";
    
    /**
	 * Check if WooCommerce is active
	 **/
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	    return "Please install / activate the WooCommerce plugin on your site.";
	}
    
    if( $skin!='' && $skin!='default' ){
        $result = "<div class='blox_skin_container $skin'>$result</div>";
    }

    return do_shortcode($result);
}

add_shortcode('blox_woo', 'blox_parse_woo_hook');

?>
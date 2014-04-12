<?php
get_header();

global $post, $wp_query, $woocommerce, $page;

$tmp_post = $post;
$temp_query = $wp_query;

if( function_exists('is_woocommerce') ){
	if( is_woocommerce() && !is_singular(array('product')) ){
		$pg_name = 'shop';
		if( is_shop() ){ $pg_name = 'shop'; }
		if( is_product_category() ){ $pg_name = 'terms'; }
		if( is_product_tag() ){ $pg_name = 'terms'; }
		if( is_cart() ){ $pg_name = 'cart'; }
		if( is_checkout() ){ $pg_name = 'checkout'; }
		if( is_account_page() ){ $pg_name = 'myaccount'; }

		$shop_page_id = woocommerce_get_page_id($pg_name);
		if( (int)$shop_page_id<1 ){
			$shop_page_id = woocommerce_get_page_id('shop');
		}
		$post = get_post($shop_page_id);
	}
}

$print_woocontent = true;
include( 'template-page.php' );


get_footer();
?>
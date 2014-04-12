<?php


add_theme_support( 'woocommerce' );

if( !function_exists('tt_woocommerce_active') ){
	function tt_woocommerce_active()
	{
		if ( class_exists( 'woocommerce' ) ){ return true; }
		return false;
	}	
}


if(!tt_woocommerce_active()) { return false; }

// custom styling
if(!is_admin()){
	add_action('init', 'register_woo_assets');
}

function register_woo_assets()
{
	wp_enqueue_style( 'woocommerce_frontend_styles', get_template_directory_uri().'/framework/config-woocommerce/woocommerce-custom-style.css');
}



//remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);


function get_mobile_shopping_cart(){
	global $woocommerce;
	if( tt_woocommerce_active() && isset($woocommerce->cart) ){
		echo '<a href="'.$woocommerce->cart->get_cart_url().'" class="show-mobile-cart visible-xs visible-sm hidden-md hidden-lg"><i class="icon-shopping-cart"></i></a>';
	}
}


/*
	SHOP CONTENT WRAPPER START
	=============================================
*/
add_action( 'woocommerce_before_shop_loop', 'ttwc_before_shop_loop', 1);
function ttwc_before_shop_loop(){
	echo "<div class='woocommerce_shop_loop'>";
}

/*
	SHOP CONTENT WRAPPER END
	=============================================
*/
add_action( 'ttwc_after_shop_loop', 'ttwc_after_shop_loop', 10);
function ttwc_after_main_content(){
	echo "</div>";
}



/*
	HIDE PAGE TITLE
	=============================================
*/
function ttwc_page_title() {
	return false;
}
add_filter('woocommerce_show_page_title', 'ttwc_page_title');







/*
	SHOP LOOP ITEM TITLE BEFORE
	=============================================
*/
add_action( 'woocommerce_before_shop_loop_item_title', 'ttwc_before_shop_loop_item_title', 10);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
function ttwc_before_shop_loop_item_title($param){
	global $product;
	$rating = $product->get_rating_html(); //get rating
	
	$id = get_the_ID();
	$size = 'full';
	
	echo "<div class='thumbnail_container'>";
		echo "<div class='product_image_hover' style='height: 246px;'>";
		echo " <a href='".get_permalink($id)."'>";
			$first_img = ttwc_gallery_first_thumbnail( $id , $size);
			if( $first_img!='' ){
				$first_img = aq_resize($first_img, 480, 480, true);
				echo '<img itemprop="image" src="'.$first_img.'" class="product-hover" />';
			}
			else{
				$fimage = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
		        $fimage = aq_resize($fimage[0], 480, 480, true);
		        echo '<img itemprop="image" src="'.$fimage.'" />';
			}
			$fimage = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
			if( isset($fimage[0]) && $fimage[0]!='' && $fimage[0]!=NULL && $fimage[0]!='NULL' ){
				$fimage = aq_resize($fimage[0], 480, 480, true);
	        	echo '<img itemprop="image" src="'.$fimage.'" />';
			}
			else{
				$first_img = aq_resize($first_img, 480, 480, true);
				echo '<img itemprop="image" src="'.$first_img.'" class="product-hover" />';
			}
	        
		echo "</a>";
		echo "</div>";
		if(!empty($rating)) echo "<span itemprop='rating' class='rating_container'>".$rating."</span>";
		if($product->product_type == 'simple') echo "<span class='cart-loading'></span>";
	echo "</div>";
}

function ttwc_gallery_first_thumbnail($id, $size){
	$active_hover = true;//get_post_meta( $id, '_product_hover', true );

	if(!empty($active_hover))
	{
		$product_gallery = get_post_meta( $id, '_product_image_gallery', true );
		
		if(!empty($product_gallery))
		{
			$gallery	= explode(',',$product_gallery);
			$image_id 	= $gallery[0];
			//$image 		= wp_get_attachment_image( $image_id, $size, false, array( 'class' => "attachment-$size product-hover" ));
			$image 		= wp_get_attachment_url($image_id);
			
			if(!empty($image)) return $image;
		}
	}
	return '';
}


/*
	SHOP LOOP ITEM TITLE AFTER
	=============================================
*/
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action( 'woocommerce_after_shop_loop_item_title', 'ttwc_template_loop_price', 10);
function ttwc_template_loop_price(){
	global $post;
	$terms = wp_get_object_terms( $post->ID, 'product_cat' );
	$numItems = count($terms);
	$i = 0;
	echo '<div class="product_categories">';
	foreach ($terms as $term) {
		if(++$i === $numItems){
			echo '<a href="'.get_term_link($term, 'product_cat').'">'.$term->name.'</a>';
		}
		else{
			echo '<a href="'.get_term_link($term, 'product_cat').'">'.$term->name.'</a>, ';
		}
	}
	echo '</div>';
}



/*
	SHOP LOOP ITEM AFTER
	=============================================
*/
add_action( 'woocommerce_after_shop_loop_item', 'ttwc_after_shop_loop_item', 16);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
function ttwc_after_shop_loop_item()
{
	global $product;

	if ($product->product_type == 'bundle' ){
		$product = new WC_Product_Bundle($product->id);
	}

	$extraClass  = "";

	ob_start();
	woocommerce_template_loop_add_to_cart();
	$output = ob_get_clean();

	if(!empty($output))
	{
		$pos = strpos($output, ">");
		
		if ($pos !== false) {
		    $output = substr_replace($output,"><span class='icon-plus'></span> ", $pos , strlen(1));
		}
	}
	
	/*
	if($product->product_type == 'variable' && empty($output))
	{
		$output = "<a class='add_to_cart_button button product_type_variable' href='".get_permalink($product->id)."'><span class='icon-shopping-cart'></span> ".__('Select options','themeton')."</a>";
	}

	if($product->product_type == 'simple')
	{
		$output .= "<a class='button show_details_button' href='".get_permalink($product->id)."'><span class='icon-shopping-cart'></span> ".__('Show Details','themeton')."</a>";
	}
	else
	{
		$extraClass  = "single_button";
	}
	*/
	 
	if(empty($extraClass)) $output .= " <span class='button-mini-delimiter'></span>";
	
	$price = $product->get_price_html();
	if($output) echo "<footer class='cart_buttons $extraClass'>$price $output</footer>";
}



?>
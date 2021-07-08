<?php
/*
   Plugin Name: product

*/

add_action('init','create_product_post');
function create_product_post()
{
	$labels = array(
		'name' => __('My Products'),
		'singular_name'=> __('product')
	);
	$args = array(
		'labels'=>$labels,
		'supports'=>array('title','editor','excerpt','author','thumbnail','comments','revision','custom-fields'),
		'description'=>"my custom post type for product",
		'public'=>true,
		 'rewrite' => array('slug' => 'my_products'),
		'taxonomies'=> array('category')
	);
	register_post_type('my_products',$args);
}

add_shortcode('show_product','list_products_function');
function list_products_function()
{

	$args = array(
		'post_type' => 'my_products',
		'posts_per_page' => '-1',
		'publish_status'=>'published',
		);
	$query = new WP_Query($args);
$str = "";
	
	$str .= '<ul>';
		while($query->have_posts()) :
			$query->the_post();
			$price = get_post_meta($query->post->ID);
				///////////////
			$quantity = $price['Product_quantity'][0];
			extract(shortcode_atts(array(  
        'label' => 'Add to Cart',
        'product' => $query->post->ID,
        'price' => $price['product_price'][0],
        'options' => ''
    ), $atts));
			$url_current = get_permalink($query->post->ID );
		if(! $quantity > 0)
		{
			$sold = "true" ;
		}
  
    if ( $sold == '' ) {
        $add_to_cart = '
            <form action="" method="post">
                <input type="hidden" name="product_id" value="' . $product . '">
                <input type="hidden" name="product_price" value="' . $price . '">
                <input type="hidden" name="product_url" value="' . $url_current . '">
                ' . $option_form . '
                <input type="hidden" name="add-to-cart" value="add-to-cart">
                <p><button type="submit" class="btn">' . $label . '</button></p>
            </form>
        ';
    }
    // If item is sold out
    else {
        $add_to_cart = '<p><strong>' . $sold . '</strong></p>';
    }
    


    /////////////////////////////////////
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $query->post->ID ), 'single-post-thumbnail' );
		
		
			$str .= '<li class="product-item">';
			$str .= '<div class="product-image">';
			$str .= '<img src="'. $image[0].'" data-id="'. $query->post->ID.'">';
			$str .= '</div>';
			$str .= '<div class="product-name">'.get_the_title().'</div>';
			$str .= '<div class="product-price">'.$price.'</div>';
			$str .= '<div class="product-add-to-cart-btn btn">'.$add_to_cart.'</div>';
			$str .= '</li>';

		endwhile;
		$str .= '</ul>';
		wp_reset_postdata();
	
	return $str;
}


add_action('init','add_to_cart_functionality');
function add_to_cart_functionality()
{

	if($_POST['add-to-cart'])
	{

		$product_name = $_POST['product_id'];
		$product_price = $_POST['product_price'];
		$product_url = $url_current;

		$product_name = stripslashes($product_name);
		$product_name_clean = array('&' => 'and','%'=>'Percent');
		$product_name = strtr($product_name,$product_name_clean);
		$product_id_cleanup = array(' ' => '_', '\'' => '', '"' => '');
		$product_id = strtr($product_name,$product_id_cleanup);
		if(!isset($_SESSION['shopping_cart']))
		{
			$_SESSION['shopping_cart']= array();
		}

		if(!isset($_SESSION['shopping_cart'][$product_id])){

			$_SESSION['shopping_cart'][$product_id] = array(
				'product_id'=> $product_id,
				'product_name' => $product_name,
				'product_price'=> $product_price,
				'Product_quantity'=> 1,
				'product_url'=>$url_clean
			);

		}
		else
		{

			$_SESSION['shopping_cart'][$product_id]['Product_quantity'] = $_SESSION['shopping_cart'][$product_id]['Product_quantity'] + 1;

		}
		$url_update = site_url()."/cart";
		header('Location:'.$url_update);
		exit();
	}
}

if(!isset($_SESSION)) {
	session_start();
}
add_shortcode('cart','cart_function');
function cart_function()
{
	if(!isset($_SESSION)) {
	session_start();
}
	$cart = " ";
	$cart_cnt = 0;
	$cart_sub_total =0;
	global $url_current;
	
	if(isset($_SESSION['shopping_cart']))
	{
		
	foreach($_SESSION['shopping_cart'] as $item)
	{

		$item_id = $item['product_id'];
		$item_name = $item['product_name'];
		$price =  $item['product_price'];
		$item_quantity = $item['Product_quantity'];
		$item_url = $item['product_url'];
		$item_total_cost = $price += $item_total_cost;
		$cart_subtotal += $item_total_cost;

		$remove_from_cart = '<a href="?action=remove-from-cart&id='. $item_id.'">remove</a>';
		$item_quantity_form = '<input type="text" name="'.$item_id.'" value="'.$quantity. ' " class="input-condensed text-center">';

		$cart_count .= '<tr><td class="text-left">Ma href="'.$item_url.'">'.$item_name.'</a><br>
		<span class="text-small">'.$item_price .'</span></td>
		<td>'.$item_quantity.'</td><td>'.$item_total_cost .'</td></tr>';

		     $checkout_cart_complete .= '
                <tr>
                    <td class="text-left">
                        <a href="' . $item_url . '">' . $item_name . '</a><br>
                        <span class="text-muted text-small">' . $item_price . '</span>
                    </td>
                    <td style="width: 4em;">' . $item_quantity . '</td>
                    <td>$' . $item_total_cost . '</td>
                </tr>
            ';
	    }
        $cart_total = $cart_subtotal;

        // Checkout cart form
        $cart = '
            <form action="" method="post">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th class="text-left">Item</th>
                            <th style="width: 4em;">#</th>
                            <th>Price</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>' . $_cart_content . '
                    </tbody>
                </table>
                <p class="no-space-bottom">Subtotal:' . $cart_subtotal . '</p>
             
                <p class="text-tall text-right">Total: ' . $cart_total . '</p>
                <p class="text-right">
                    <button type="submit" name="submit" value="update-cart" class="btn btn-muted">Update</button>
                    <button type="submit" name="submit" value="cart-checkout" class="btn">Checkout</button>
                </p>
            </form>
            <p class="text-right"><img src="' . $img_directory . 'paypal.jpg" height="53" width="200" alt="Secure payments by PayPal. Pay with Visa, Mastercard, Discover or American Express."></p>
        ';

    }

		    if ( $url_current == $url_success && isset($_SESSION['shopping_cart']) ) {

		        // Success message and purchase summary
		        $checkout_cart = '
		            <p>Thanks for your purchase <a href="mailto:' . $paypal_account . '">' . $paypal_account . '</a>.</p>
		            <h3>Order Summary</h3>
		            <table class="table">
		                <thead>
		                    <tr>
		                        <th>Item</th>
		                        <th style="width: 4em;">#</th>
		                        <th>Price</th>
		                    </tr>
		                </thead>
		                <tbody>' . $checkout_cart_complete . '
		                </tbody>
		            </table>
		            <p class="no-space-bottom text-right">Subtotal: $' . $checkout_cart_subtotal . '</p>
		            <p class="space-bottom-small text-right">Shipping: $' . $checkout_cart_shipping . '</p>
		            <p class="text-tall text-right">Total: $' . $checkout_cart_total . '</p>
		        ';

		        // Empty cart
		        unset($_SESSION['shopping_cart']);
		        
		    }

		    // If cart is empty
		    elseif ( $checkout_cart_count == 0 ) {
		        $checkout_cart = '<p>Your shopping cart is empty. <a href="' . $url_store . '">Visit the store.</a></p>';
		    }

		   // Display checkout cart
		    return $checkout_cart;
    

	
}
?>

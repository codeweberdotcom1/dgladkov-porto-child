<?php

add_action( 'wp_enqueue_scripts', 'porto_child_css', 1001 );

// Load CSS
function porto_child_css() {
	// porto child theme styles
	wp_deregister_style( 'styles-child' );
	wp_register_style( 'styles-child', esc_url( get_stylesheet_directory_uri() ) . '/style.css' );
	wp_enqueue_style( 'styles-child' );

	if ( is_rtl() ) {
		wp_deregister_style( 'styles-child-rtl' );
		wp_register_style( 'styles-child-rtl', esc_url( get_stylesheet_directory_uri() ) . '/style_rtl.css' );
		wp_enqueue_style( 'styles-child-rtl' );
	}
}

/**
* Move WooCommerce subcategory list items into
* their own <ul> separate from the product <ul>.
*/

add_action( 'init', 'move_subcat_lis' );

function move_subcat_lis() {
	// Remove the subcat <li>s from the old location.
	remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );
	add_action( 'woocommerce_before_shop_loop', 'msc_product_loop_start', 1 );
	add_action( 'woocommerce_before_shop_loop', 'msc_maybe_show_product_subcategories', 2 );
	add_action( 'woocommerce_before_shop_loop', 'msc_product_loop_end', 3 );
}

/**
 * Conditonally start the product loop with a <ul> contaner if subcats exist.
 */
function msc_product_loop_start() {
	$subcategories = woocommerce_maybe_show_product_subcategories();
	if ( $subcategories ) {
		woocommerce_product_loop_start();
	}
}

/**
 * Print the subcat <li>s in our new location.
 */
function msc_maybe_show_product_subcategories() {
	echo woocommerce_maybe_show_product_subcategories();
}

/**
 * Conditonally end the product loop with a </ul> if subcats exist.
 */
function msc_product_loop_end() {
	$subcategories = woocommerce_maybe_show_product_subcategories();
	if ( $subcategories ) {
		woocommerce_product_loop_end();
	}
}


/**WC Отключение оплаты при оформлении**/
add_filter( 'woocommerce_cart_needs_payment', '__return_false' );
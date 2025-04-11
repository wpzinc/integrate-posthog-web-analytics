<?php
/**
 * PostHog WooCommerce integration class.
 *
 * @package PostHog
 * @author WP Zinc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * PostHog WooCommerce integration class.
 *
 * @package PostHog
 * @author WP Zinc
 */
class Integrate_PHWA_WooCommerce extends Integrate_PHWA_API {

    public function __construct() {

        add_action( 'woocommerce_after_single_product', array( $this, 'view_product' ) );
        add_action( 'woocommerce_before_shop_loop', array( $this, 'view_product_list' ) );
        add_action( 'woocommerce_add_to_cart', array( $this, 'add_to_cart' ), 10, 6 );
        add_action( 'woocommerce_cart_updated', array( $this, 'update_cart' ) );
        add_action( 'woocommerce_before_cart', array( $this, 'view_cart' ) );
        add_action( 'woocommerce_thankyou', array( $this, 'purchase' ), 10, 1 );

    }

    public function view_product() {

        global $product;

        $properties = array(
            'product_id' => $product->get_id(),
            'product_name' => $product->get_name(),
            'product_price' => $product->get_price(),
            'product_sku' => $product->get_sku(),
            'product_categories' => wp_list_pluck(get_the_terms($product->get_id(), 'product_cat'), 'name'),
            'product_tags' => wp_list_pluck(get_the_terms($product->get_id(), 'product_tag'), 'name'),
            'stock_quantity' => $product->get_stock_quantity(),
            'stock_status' => $product->get_stock_status(),
            'currency' => get_woocommerce_currency()
        );
        
        $this->capture_event('view_product', $properties);

    }

    public function view_product_list() {

        $queried_object = get_queried_object();
        $properties = array(
            'list_name' => is_product_category() ? 'Category: ' . $queried_object->name : 'Shop',
            'products' => array()
        );

        $products = wc_get_products(array(
            'status' => 'publish',
            'limit' => -1,
            'category' => is_product_category() ? array($queried_object->slug) : array(),
        ));

        foreach ($products as $product) {
            $properties['products'][] = array(
                'product_id' => $product->get_id(),
                'product_name' => $product->get_name(),
                'product_price' => $product->get_price(),
                'product_sku' => $product->get_sku(),
                'product_categories' => wp_list_pluck(get_the_terms($product->get_id(), 'product_cat'), 'name'),
                'product_tags' => wp_list_pluck(get_the_terms($product->get_id(), 'product_tag'), 'name'),
            );
        }

        $this->capture_event('view_product_list', $properties);

    }

    public function add_to_cart( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart ) {

        $product = wc_get_product($product_id);
        $properties = array(
            'product_id' => $product_id,
            'product_name' => $product->get_name(),
            'product_price' => $product->get_price(),
            'quantity' => $quantity,
            'total_price' => $product->get_price() * $quantity,
            'currency' => get_woocommerce_currency(),
            'product_sku' => $product->get_sku(),
            'product_categories' => wp_list_pluck(get_the_terms($product_id, 'product_cat'), 'name'),
            'product_tags' => wp_list_pluck(get_the_terms($product_id, 'product_tag'), 'name'),
            'stock_quantity' => $product->get_stock_quantity(),
            'stock_status' => $product->get_stock_status()
        );
            
        if ($variation_id) {
            $properties['variation_id'] = $variation_id;
            $variation_product = wc_get_product($variation_id);
            $properties['variation_sku'] = $variation_product->get_sku();
            $properties['variation_attributes'] = $variation_product->get_variation_attributes();
        }
        
        $this->capture_event( 'add_to_cart', $properties );

    }

    public function update_cart() {

        $cart = WC()->cart;
        $properties = array(
            'cart_total' => $cart->get_cart_contents_total(),
            'cart_subtotal' => $cart->get_subtotal(),
            'currency' => get_woocommerce_currency(),
            'num_items' => $cart->get_cart_contents_count(),
            'coupon_codes' => $cart->get_applied_coupons()
        );
        $this->capture_event('cart_updated', $properties);

    }

    public function view_cart() {

        $cart = WC()->cart;
        $properties = array(
            'cart_total' => $cart->get_cart_contents_total(),
            'cart_subtotal' => $cart->get_subtotal(),
    



}
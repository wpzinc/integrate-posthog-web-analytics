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

    /**
     * Constructor. Defines the actions to track events on.
     * 
     * @since   1.1.0
     */
    public function __construct() {

        // Register actions to track events.
        add_action( 'woocommerce_after_single_product', array( $this, 'view_product' ) );
        add_action( 'woocommerce_add_to_cart', array( $this, 'add_to_cart' ), 10, 6 );
        add_action( 'woocommerce_cart_updated', array( $this, 'update_cart' ) );
        add_action( 'woocommerce_before_cart', array( $this, 'view_cart' ) );
        add_action( 'woocommerce_before_checkout_form', array($this, 'track_checkout_started'));
        add_action( 'wp_footer', array($this, 'track_checkout_initiated'));
        add_action( 'woocommerce_checkout_update_order_review', array($this, 'track_checkout_progress'));
        add_action( 'woocommerce_checkout_order_processed', array($this, 'track_order_received'));
        add_action( 'woocommerce_thankyou', array( $this, 'purchase' ), 10, 1 );
        add_action( 'shutdown', array( $this, 'send_events' ) );
        
    }

    /**
     * Capture event when a product is viewed.
     * 
     * @since   1.1.0
     */
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

        $this->capture_event('cart_view', $this->get_cart_data());
    
    }

    public function track_checkout_started() {

        $this->capture_event('checkout_initiated', $this->get_cart_data());

    }

    public function track_checkout_progress() {

        $this->capture_event('checkout_progress', array(
            'step' => 'order_review'
        ));

    }

    public function track_order_received() {

        $order = wc_get_order($order_id);
        if (!$order) return;

        $total = floatval($order->get_total());
        $tax = floatval($order->get_total_tax());
        $shipping = floatval($order->get_shipping_total());
        
        $purchase_data = array(
            'transaction_id' => $order_id,
            'affiliation' => get_bloginfo('name'),
            'value' => $total, // Keep original value for backwards compatibility
            'revenue' => $total - $tax - $shipping, // New revenue property excluding tax and shipping
            'tax' => $tax,
            'shipping' => $shipping,
            'currency' => $order->get_currency(),
            'coupon' => implode(', ', $order->get_coupon_codes()),
            'items' => $this->get_order_items($order)
        );

        $this->capture_event('purchase', $purchase_data);

    }
    
    

    public function purchase( $order_id ) {

        $order = wc_get_order($order_id);
        $product_data = array();
        foreach ($items as $item) {
            $product = $item->get_product();
            $product_data[] = array(
                'name' => $product->get_name(),
                'id' => $product->get_id(),
                'sku' => $product->get_sku(),
                'price' => $product->get_price(),
                'quantity' => $item->get_quantity(),
                'categories' => wp_list_pluck(get_the_terms($product->get_id(), 'product_cat'), 'name')
            );
        }

        $properties = array(
            'order_id' => $order_id,
            'order_total' => floatval($order->get_total()),
            'currency' => $order->get_currency(),
            'products' => $product_data,
            'num_items' => count($items),
            'payment_method' => $order->get_payment_method(),
            'shipping_method' => $order->get_shipping_method(),
            'coupon_codes' => $order->get_coupon_codes()
        );

        $this->capture_event('order_completed', $properties);

    }

    private function get_cart_data() {
        if (!function_exists('WC')) {
            return array();
        }
        $cart = WC()->cart;
        $cart_items = $cart->get_cart();
        $product_data = array();

        foreach ($cart_items as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
            $product_data[] = array(
                'name' => $product->get_name(),
                'id' => $product->get_id(),
                'sku' => $product->get_sku(),
                'price' => $product->get_price(),
                'quantity' => $cart_item['quantity'],
                'categories' => wp_list_pluck(get_the_terms($product->get_id(), 'product_cat'), 'name')
            );
        }

        return array(
            'cart_total' => $cart->get_cart_contents_total(),
            'cart_subtotal' => $cart->get_subtotal(),
            'currency' => get_woocommerce_currency(),
            'products' => $product_data,
            'num_items' => $cart->get_cart_contents_count(),
            'coupon_codes' => $cart->get_applied_coupons()
        );
    }

    private function get_order_items($order) {
        if (!function_exists('WC')) {
            return array();
        }
        $items = array();
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();
            $items[] = array(
                'id' => $product->get_id(),
                'name' => $item->get_name(),
                'category' => $this->get_product_category($product),
                'quantity' => $item->get_quantity(),
                'price' => $order->get_item_total($item)
            );
        }
        return $items;
    }

}
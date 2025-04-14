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

		// Bail if WooCommerce is not active.
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			return;
		}

		// Get settings instance.
		$settings = new Integrate_PHWA_Settings_WooCommerce();

		// Register actions to track events.
		if ( $settings->event_view_product() ) {
			add_action( 'woocommerce_after_single_product', array( $this, 'view_product' ) );
		}
		if ( $settings->event_add_to_cart() ) {
			add_action( 'woocommerce_add_to_cart', array( $this, 'add_to_cart' ), 10, 6 );
		}
		if ( $settings->event_update_cart() ) {
			add_action( 'woocommerce_cart_updated', array( $this, 'update_cart' ) );
		}
		if ( $settings->event_view_cart() ) {
			add_action( 'woocommerce_before_cart', array( $this, 'view_cart' ) );
		}
		if ( $settings->event_checkout_started() ) {
			add_action( 'woocommerce_before_checkout_form', array( $this, 'track_checkout_started' ) );
		}
		if ( $settings->event_checkout_in_progress() ) {
			add_action( 'woocommerce_checkout_update_order_review', array( $this, 'track_checkout_in_progress' ) );
		}
		if ( $settings->event_checkout_completed() ) {
			add_action( 'woocommerce_thankyou', array( $this, 'track_checkout_completed' ), 10, 1 );
		}

		// Send events on shutdown.
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
			'product_id'    => $product->get_id(),
			'product_name'  => $product->get_name(),
			'product_price' => $product->get_price(),
		);

		$this->capture_event( 'view_product', $properties );

	}

	/**
	 * Capture event when a product list is viewed.
	 *
	 * @since   1.1.0
	 */
	public function view_product_list() {

		$queried_object = get_queried_object();
		$properties     = array(
			'list_name' => is_product_category() ? 'Category: ' . $queried_object->name : 'Shop',
			'products'  => array(),
		);

		$products = wc_get_products(
			array(
				'status'   => 'publish',
				'limit'    => -1,
				'category' => is_product_category() ? array( $queried_object->slug ) : array(),
			)
		);

		foreach ( $products as $product ) {
			$properties['products'][] = array(
				'product_id'         => $product->get_id(),
				'product_name'       => $product->get_name(),
				'product_price'      => $product->get_price(),
				'product_sku'        => $product->get_sku(),
				'product_categories' => wp_list_pluck( get_the_terms( $product->get_id(), 'product_cat' ), 'name' ),
				'product_tags'       => wp_list_pluck( get_the_terms( $product->get_id(), 'product_tag' ), 'name' ),
			);
		}

		$this->capture_event( 'view_product_list', $properties );

	}

	/**
	 * Capture event when a product is added to the cart.
	 *
	 * @since   1.1.0
	 *
	 * @param string  $cart_id ID of the item in the cart.
	 * @param integer $product_id ID of the product added to the cart.
	 * @param integer $request_quantity Quantity of the item added to the cart.
	 * @param integer $variation_id Variation ID of the product added to the cart.
	 * @param array   $variation Array of variation data.
	 * @param array   $cart_item_data Array of other cart item data.
	 */
	public function add_to_cart( $cart_id, $product_id, $request_quantity, $variation_id, $variation, $cart_item_data ) {

		$product    = wc_get_product( $product_id );
		$properties = array(
			'product_id'    => $product_id,
			'product_name'  => $product->get_name(),
			'product_price' => $product->get_price(),
		);

		if ( $variation_id ) {
			$properties['variation_id']         = $variation_id;
			$variation_product                  = wc_get_product( $variation_id );
			$properties['variation_sku']        = $variation_product->get_sku();
			$properties['variation_attributes'] = $variation_product->get_variation_attributes();
		}

		$this->capture_event( 'add_to_cart', $properties );

	}

	/**
	 * Capture event when the cart is updated.
	 *
	 * @since   1.1.0
	 */
	public function update_cart() {

		$cart       = WC()->cart;
		$properties = array(
			'cart_total'    => $cart->get_cart_contents_total(),
			'cart_subtotal' => $cart->get_subtotal(),
			'currency'      => get_woocommerce_currency(),
			'num_items'     => $cart->get_cart_contents_count(),
			'coupon_codes'  => $cart->get_applied_coupons(),
		);
		$this->capture_event( 'cart_updated', $properties );

	}

	/**
	 * Capture event when the cart is viewed.
	 *
	 * @since   1.1.0
	 */
	public function view_cart() {

		$this->capture_event( 'cart_view', $this->get_cart_data() );

	}

	/**
	 * Capture event when the checkout is started.
	 *
	 * @since   1.1.0
	 */
	public function track_checkout_started() {

		$this->capture_event( 'checkout_initiated', $this->get_cart_data() );

	}

	/**
	 * Capture event when the checkout is in progress.
	 *
	 * @since   1.1.0
	 */
	public function track_checkout_in_progress() {

		$this->capture_event(
			'checkout_in_progress',
			array(
				'step' => 'order_review',
			)
		);

	}

	/**
	 * Capture event when the checkout is completed.
	 *
	 * @since   1.1.0
	 *
	 * @param integer $order_id ID of the order.
	 */
	public function track_checkout_completed( $order_id ) {

		$order        = wc_get_order( $order_id );
		$product_data = array();
		foreach ( $items as $item ) {
			$product        = $item->get_product();
			$product_data[] = array(
				'name'       => $product->get_name(),
				'id'         => $product->get_id(),
				'sku'        => $product->get_sku(),
				'price'      => $product->get_price(),
				'quantity'   => $item->get_quantity(),
				'categories' => wp_list_pluck( get_the_terms( $product->get_id(), 'product_cat' ), 'name' ),
			);
		}

		$properties = array(
			'order_id'        => $order_id,
			'order_total'     => floatval( $order->get_total() ),
			'currency'        => $order->get_currency(),
			'products'        => $product_data,
			'num_items'       => count( $items ),
			'payment_method'  => $order->get_payment_method(),
			'shipping_method' => $order->get_shipping_method(),
			'coupon_codes'    => $order->get_coupon_codes(),
		);

		$this->capture_event( 'order_completed', $properties );

	}

	/**
	 * Get the cart data.
	 *
	 * @since   1.1.0
	 *
	 * @return array Cart data.
	 */
	private function get_cart_data() {

		if ( ! function_exists( 'WC' ) ) {
			return array();
		}

		$cart         = WC()->cart;
		$cart_items   = $cart->get_cart();
		$product_data = array();

		foreach ( $cart_items as $cart_item_key => $cart_item ) {
			$product        = $cart_item['data'];
			$product_data[] = array(
				'name'       => $product->get_name(),
				'id'         => $product->get_id(),
				'sku'        => $product->get_sku(),
				'price'      => $product->get_price(),
				'quantity'   => $cart_item['quantity'],
				'categories' => wp_list_pluck( get_the_terms( $product->get_id(), 'product_cat' ), 'name' ),
			);
		}

		return array(
			'cart_total'    => $cart->get_cart_contents_total(),
			'cart_subtotal' => $cart->get_subtotal(),
			'currency'      => get_woocommerce_currency(),
			'products'      => $product_data,
			'num_items'     => $cart->get_cart_contents_count(),
			'coupon_codes'  => $cart->get_applied_coupons(),
		);

	}

	/**
	 * Get the order items.
	 *
	 * @since   1.1.0
	 *
	 * @param object $order Order object.
	 * @return array Order items.
	 */
	private function get_order_items( $order ) {

		if ( ! function_exists( 'WC' ) ) {
			return array();
		}

		$items = array();

		foreach ( $order->get_items() as $item ) {
			$product = $item->get_product();
			$items[] = array(
				'id'       => $product->get_id(),
				'name'     => $item->get_name(),
				'category' => $this->get_product_category( $product ),
				'quantity' => $item->get_quantity(),
				'price'    => $order->get_item_total( $item ),
			);
		}

		return $items;

	}

}

// Bootstrap.
add_action(
	'integrate_phwa_initialize_global',
	function () {

		new Integrate_PHWA_WooCommerce();

	}
);

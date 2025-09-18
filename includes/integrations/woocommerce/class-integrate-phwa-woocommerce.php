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
class Integrate_PHWA_WooCommerce {

	use Integrate_PHWA_API_Trait;

	/**
	 * Constructor. Defines the actions to track events on.
	 *
	 * @since   1.1.0
	 */
	public function __construct() {

		// Bail if WooCommerce is not active.
		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		// Get settings instances.
		$plugin_settings = new Integrate_PHWA_Settings();
		$settings        = new Integrate_PHWA_Settings_WooCommerce();

		// Bail if the Plugin is not enabled.
		if ( ! $plugin_settings->enabled() ) {
			return;
		}

		// Define API Key and Cloud Country.
		$this->api_key       = $plugin_settings->project_api_key();
		$this->cloud_country = $plugin_settings->project_region();

		// Register actions to track events.
		if ( $settings->event_view_product() ) {
			add_action( 'woocommerce_after_single_product', array( $this, 'view_product' ) );
		}
		if ( $settings->event_add_to_cart() ) {
			add_action( 'woocommerce_add_to_cart', array( $this, 'add_to_cart' ), 10, 6 );
		}
		if ( $settings->event_update_cart() ) {
			add_filter( 'woocommerce_cart_updated_notice_type', array( $this, 'update_cart' ) );
		}
		if ( $settings->event_view_cart() ) {
			// Non-block based carts.
			add_action( 'woocommerce_before_cart', array( $this, 'view_cart' ) );

			// Block based carts.
			add_action(
				'template_redirect',
				function () {
					if ( function_exists( 'is_cart' ) && is_cart() ) {
						$this->view_cart();
					}
				}
			);
		}
		if ( $settings->event_view_checkout() ) {
			// Non-block based checkout.
			add_action( 'woocommerce_before_checkout_form', array( $this, 'view_checkout' ) );

			// Block based checkout.
			add_action(
				'template_redirect',
				function () {
					if ( function_exists( 'is_checkout' ) && is_checkout() ) {
						$this->view_checkout();
					}
				}
			);
		}
		if ( $settings->event_completed_checkout() ) {
			add_action( 'woocommerce_thankyou', array( $this, 'completed_checkout' ), 10, 1 );
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

		$this->capture_event( 'WooCommerce: View Product', $properties );

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
	public function add_to_cart( $cart_id, $product_id, $request_quantity, $variation_id, $variation, $cart_item_data ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed

		// Get WooCommerce Product.
		$product = wc_get_product( $product_id );

		// Bail if product does not exist.
		if ( ! $product ) {
			return;
		}

		// Capture event.
		$this->capture_event( 'WooCommerce: Add Product to Cart', $this->get_product_data( $product, $variation_id, $request_quantity ) );

	}

	/**
	 * Capture event when the cart is updated.
	 *
	 * @since   1.1.0
	 *
	 * @param   string $type   Notification type.
	 * @return  string          Notification type
	 */
	public function update_cart( $type ) {

		$this->capture_event( 'WooCommerce: Update Cart', $this->get_cart_data() );

		return $type;

	}

	/**
	 * Capture event when the cart is viewed.
	 *
	 * @since   1.1.0
	 */
	public function view_cart() {

		$this->capture_event( 'WooCommerce: View Cart', $this->get_cart_data() );

	}

	/**
	 * Capture event when the checkout is viewed.
	 *
	 * @since   1.1.0
	 */
	public function view_checkout() {

		$this->capture_event( 'WooCommerce: Checkout Started', $this->get_cart_data() );

	}

	/**
	 * Capture event when the checkout is completed.
	 *
	 * @since   1.1.0
	 *
	 * @param integer $order_id ID of the order.
	 */
	public function completed_checkout( $order_id ) {

		// Get order.
		$order = wc_get_order( $order_id );

		if ( ! $order ) {
			return;
		}

		// Get products.
		$items    = $order->get_items();
		$products = array();
		foreach ( $items as $item ) {
			$products[] = $this->get_product_data( $item->get_product(), $item->get_variation_id(), $item->get_quantity() ); // @phpstan-ignore-line
		}

		// Build properties.
		$properties = array(
			'order_id'        => $order_id,
			'order_total'     => $order->get_total(),
			'currency'        => $order->get_currency(),
			'quantity'        => count( $items ),
			'payment_method'  => $order->get_payment_method(),
			'shipping_method' => $order->get_shipping_method(),
			'coupon_codes'    => $order->get_coupon_codes(),
			'products'        => $products,
		);

		$this->capture_event( 'WooCommerce: Checkout Completed', $properties );

	}

	/**
	 * Helper method to fetch the WooCommerce cart data.
	 *
	 * @since   1.1.0
	 *
	 * @return array Cart data.
	 */
	private function get_cart_data() {

		// Get cart.
		$cart       = WC()->cart;
		$cart_items = $cart->get_cart();
		$products   = array();

		// Get product data for each item in cart.
		foreach ( $cart_items as $cart_item_key => $cart_item ) {
			$products[] = $this->get_product_data( $cart_item['data'], $cart_item['variation_id'], $cart_item['quantity'] );
		}

		return array(
			'cart_total'    => $cart->get_cart_contents_total(),
			'cart_subtotal' => $cart->get_subtotal(),
			'currency'      => get_woocommerce_currency(),
			'quantity'      => $cart->get_cart_contents_count(),
			'coupon_codes'  => $cart->get_applied_coupons(),
			'products'      => $products,
		);

	}

	/**
	 * Helper method to fetch WooCommerce Product data.
	 *
	 * @since   1.1.0
	 *
	 * @param   WC_Product $product      WooCommerce Product object.
	 * @param   integer    $variation_id Variation ID.
	 * @param   integer    $quantity     Quantity.
	 * @return  array                    Product data.
	 */
	private function get_product_data( $product, $variation_id = 0, $quantity = 1 ) {

		// Build properties.
		$properties = array(
			'id'       => $product->get_id(),
			'name'     => $product->get_name(),
			'sku'      => $product->get_sku(),
			'price'    => $product->get_price(),
			'quantity' => $quantity,
		);

		// If a variation was added to the cart, add the variation ID and attributes.
		if ( $variation_id ) {
			$properties['product_variation_id']         = $variation_id;
			$variation_product                          = wc_get_product( $variation_id );
			$properties['product_variation_sku']        = $variation_product->get_sku();
			$properties['product_variation_attributes'] = $variation_product->get_variation_attributes(); // @phpstan-ignore-line
		}

		return $properties;

	}

}

// Bootstrap.
add_action(
	'integrate_phwa_initialize_global',
	function () {

		new Integrate_PHWA_WooCommerce();

	}
);

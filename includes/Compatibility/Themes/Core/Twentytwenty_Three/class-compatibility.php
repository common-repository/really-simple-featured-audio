<?php
/**
 * Twenty Twenty Three theme compatibility handler.
 *
 * @package RSFA
 */

namespace RSFA\Compatibility\Themes\Core\Twentytwenty_Three;

use RSFA\Compatibility\Themes\Base_Compatibility;

/**
 * Class Compatibility
 *
 * @package RSFA
 */
class Compatibility extends Base_Compatibility {
	/**
	 * Class instance.
	 *
	 * @var $instance
	 */
	protected static $instance;

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->id = 'twentytwentythree';

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		if ( has_action( 'rsfa_woo_archives_product_thumbnails', 'woocommerce_template_loop_product_thumbnail' ) ) {
			remove_action( 'rsfa_woo_archives_product_thumbnails', 'woocommerce_template_loop_product_thumbnail', 10 );
		}
	}

	/**
	 * Enqueue scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		// Register styles.
		wp_register_style( 'rsfa-twentytwentythree', $this->get_current_dir_url() . 'Core/Twentytwenty_Three/styles.css', array(), filemtime( $this->get_current_dir() . 'Core/Twentytwenty_Three/styles.css' ) );

		// Enqueue styles.
		wp_enqueue_style( 'rsfa-twentytwentythree' );
	}
}

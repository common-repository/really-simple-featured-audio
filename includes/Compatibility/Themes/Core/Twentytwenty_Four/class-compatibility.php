<?php
/**
 * Twenty Twenty Four theme compatibility handler.
 *
 * @package RSFA
 */

namespace RSFA\Compatibility\Themes\Core\Twentytwenty_Four;

use RSFA\Compatibility\Themes\Base_Compatibility;
use RSFA\Options;

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

		$this->id = 'twentytwentyfour';

		$this->setup();

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
		wp_register_style( 'rsfa-twentytwentyfour', $this->get_current_dir_url() . 'Core/Twentytwenty_Four/styles.css', array(), filemtime( $this->get_current_dir() . 'Core/Twentytwenty_Four/styles.css' ) );

		// Enqueue styles.
		wp_enqueue_style( 'rsfa-twentytwentyfour' );
	}

	/**
	 * Setup compat.
	 *
	 * @return void
	 */
	public function setup() {
		// Removes old support for Woo FSE archives.
		$this->remove_woo_fse_archives_support();
	}

	/**
	 * Removes Woo Archives support for fse themes.
	 *
	 * @return void
	 */
	public function remove_woo_fse_archives_support() {
		if ( ! class_exists( '\WooCommerce' ) ) {
			return;
		}

		$options = Options::get_instance();

		$woo_archives_supported = $options->get( 'woo_archives_supported', true );

		if ( $woo_archives_supported ) {
			$options->set( 'woo_archives_supported', false );
		}
	}
}

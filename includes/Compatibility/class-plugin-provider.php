<?php
/**
 * Plugin compatibility handler.
 *
 * @package RSFA
 */

namespace RSFA\Compatibility;

use RSFA\Options;

/**
 * Class Plugin_Provider
 *
 * @package RSFA
 */
class Plugin_Provider {
	const COMPAT_DIR = RSFA_PLUGIN_DIR . 'includes/Compatibility/Plugins/';
	const COMPAT_URL = RSFA_PLUGIN_URL . 'includes/Compatibility/Plugins/';

	/**
	 * Class instance.
	 *
	 * @var $instance
	 */
	protected static $instance;

	/**
	 * Plugin engines.
	 *
	 * @var array $plugin_engines
	 */
	private $plugin_engines;

	/**
	 * Constructor.
	 */
	public function __construct() {

		// Register plugin engines.
		$this->plugin_engines = apply_filters(
			'rsfa_plugin_compatibility_engines',
			array(
				'woocommerce' => array(
					'title'            => __( 'WooCommerce', 'really-simple-featured-audio' ),
					'file_source'      => self::COMPAT_DIR . 'WooCommerce/class-compatibility.php',
					'class'            => 'RSFA\Compatibility\Plugins\WooCommerce\Compatibility',
					'has_class_loaded' => 'WooCommerce',
				),
				'elementor'   => array(
					'title'            => __( 'Elementor', 'really-simple-featured-audio' ),
					'file_source'      => RSFA_PLUGIN_DIR . 'includes/Compatibility/Plugins/Elementor/class-compatibility.php',
					'class'            => 'RSFA\Compatibility\Plugins\Elementor\Compatibility',
					'has_class_loaded' => 'Elementor\Plugin',
				),
			)
		);

		$this->load_plugin_compat();
	}

	/**
	 * Get a class instance.
	 *
	 * @return Object
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * Load plugin compatibility.
	 *
	 * @return void
	 */
	public function load_plugin_compat() {
		$options = Options::get_instance();

		$plugin_compat = null;

		foreach ( $this->plugin_engines as $plugin_engine => $plugin_data ) {
			if ( ! class_exists( $plugin_data['has_class_loaded'] ) ) {
				continue;
			}

			require_once $plugin_data['file_source'];
			$plugin_compat = $plugin_data['class']::get_instance();
		}
	}

	/**
	 * Get registered engines id and title.
	 *
	 * @return array
	 */
	public function get_available_engines() {
		$registered_engines = array();

		foreach ( $this->plugin_engines as $engine_id => $engine_data ) {
			$registered_engines[ $engine_id ] = $engine_data['title'];
		}

		return $registered_engines;
	}

	/**
	 * Get selectable engines for user settings.
	 *
	 * @return array
	 */
	public function get_selectable_engine_options() {
		$selectable_engines = array();

		foreach ( $this->plugin_engines as $engine_id => $engine_data ) {
			$selectable_engines[ $engine_id ] = $engine_data['title'];
		}

		return $selectable_engines;
	}
}

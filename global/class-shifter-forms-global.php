<?php
/**
 * The global functionality of the plugin.
 *
 * @link  https://www.getshifter.io
 * @since 1.0.0
 *
 * @package    Shifter_Forms
 * @subpackage Shifter_Forms/global
 */

/**
 * The global functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Shifter_Forms
 * @subpackage Shifter_Forms/global
 * @author     DigitalCube <hello@getshifter.io>
 */
class Shifter_Forms_Global {

	/**
	 * The ID of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/shifter-forms-global.css', array( 'jquery', 'micromodal' ), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		$admin = new Shifter_Forms_Admin($this->plugin_name, $this->version);
		$data = $admin->shifter_forms_output();

		$shifter_forms_data = array(
			'data' => $data,
		);

		wp_register_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/shifter-forms-global.js',
			array( 'jquery' ),
			$this->version,
			true
		);

		wp_localize_script( $this->plugin_name, 'shifterForms', $shifter_forms_data );
		wp_enqueue_script( $this->plugin_name );

		// MicroModal.
		wp_register_script('micromodal', 'https://cdn.jsdelivr.net/npm/micromodal/dist/micromodal.min.js', null, null, true);
		wp_enqueue_script('micromodal');
	}

}

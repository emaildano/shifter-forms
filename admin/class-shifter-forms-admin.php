<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.getshifter.io
 * @since      1.0.0
 *
 * @package    Shifter_Forms
 * @subpackage Shifter_Forms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Shifter_Forms
 * @subpackage Shifter_Forms/admin
 * @author     DigitalCube <hello@getshifter.io>
 */
class Shifter_Forms_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Shifter_Forms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shifter_Forms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/shifter-forms-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Shifter_Forms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shifter_Forms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/shifter-forms-admin.js', array( 'jquery' ), $this->version, false );

	}

		// register the Shifter form content type.
	public function register_shifter_forms_content_type() {
		// Labels.
		$labels = array(
			'name'               => 'Shifter Forms',
			'singular_name'      => 'Shifter Form',
			'menu_name'          => 'Shifter Forms',
			'name_admin_bar'     => 'Shifter Form',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Form',
			'new_item'           => 'New Form',
			'edit_item'          => 'Edit Form',
			'view_item'          => 'View Form',
			'all_items'          => 'Shifter Forms',
			'search_items'       => 'Search Forms',
			'parent_item_colon'  => 'Parent Form:',
			'not_found'          => 'No Forms found.',
			'not_found_in_trash' => 'No Forms found in Trash.',
		);
		// Arguments.
		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_nav'        => true,
			'query_var'          => true,
			'hierarchical'       => false,
			'supports'           => array( 'title' ),
			'has_archive'        => false,
			'menu_position'      => 20,
			'show_in_admin_bar'  => true,
			'show_in_menu'       => 'tools.php',
			'menu_icon'          => 'dashicons-feedback',
		);
		// Register post type.
		register_post_type( 'shifter_forms', $args );
	}

	// Adding meta boxes.
	public function add_form_meta_boxes() {

		add_meta_box(
			'shifter_forms_meta_box',
			'Form Information',
			array( $this, 'form_meta_box_display' ),
			'shifter_forms',
			'normal',
			'default'
		);
	}

	// Meta box display.
	public function form_meta_box_display( $post ) {

		// set nonce field
		wp_nonce_field( 'shifter_form_nonce', 'shifter_form_nonce_field' );

		// collect variables
		$shifter_form_target       = get_post_meta( $post->ID, 'shifter_form_target', true );
		$shifter_form_action       = get_post_meta( $post->ID, 'shifter_form_action', true );
		$shifter_form_confirmation = get_post_meta( $post->ID, 'shifter_form_confirmation', true );

		?>
	<div class="field-container form-table">
		<?php
		// before main form hook.
		do_action( 'shifter_form_admin_form_start' );
		?>
		<div class="field">
			<label for="shifter_form_target">Target</label>
			<p class="description">Supports comma separated values.</p>
			<input class="regular-text code" type="text" name="shifter_form_target" id="shifter_form_target" placeholder="For example: form.wpcf7-form, #gform_3" value="<?php echo $shifter_form_target; ?>"/>
		</div>
		<div class="field">
			<label for="shifter_form_action">Action URL / Outgoing Webhook</label>
			<p class="description">URL to POST request on form submission.</p>
			<input class="regular-text code" type="url" name="shifter_form_action" id="shifter_form_action" placeholder="For example: https://example.com/webhook " value="<?php echo $shifter_form_action; ?>"/>
		</div>
		<div class="field">
			<label for="shifter_form_confirmation">Confirmation Page</label>
			<p class="description">Redirect to this page on submit.</p>
			<input class="regular-text code" type="text" name="shifter_form_confirmation" id="shifter_form_confirmation" placeholder="For example: /thank-you " value="<?php echo $shifter_form_confirmation; ?>"/>
		</div>
		<?php
		// after main form hook.
		do_action( 'shifter_form_admin_form_end' );
		?>
	</div>
		<?php

	}

	// Main function for outputting forms.
	public function shifter_forms_output() {

		$html = array();

		$shifter_form_args = array(
			'post_type'      => 'shifter_forms',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		);

		$forms = new WP_Query( $shifter_form_args );
		$forms = $forms->get_posts();

		if ( $forms ) {
			foreach ( $forms as $form ) {
				$post_id = $form->ID;
				$html[]  = array(
					'shifter_form_target'       => get_post_meta( $post_id, 'shifter_form_target', true ),
					'shifter_form_action'       => get_post_meta( $post_id, 'shifter_form_action', true ),
					'shifter_form_confirmation' => get_post_meta( $post_id, 'shifter_form_confirmation', true ),
				);
			}
		}

		return $html;
	}

	// Triggered when adding or editing a form.
	public function save_form( $post_id ) {

		// check for nonce.
		if ( ! isset( $_POST['shifter_form_nonce_field'] ) ) {
			return $post_id;
		}
		// verify nonce.
		if ( ! wp_verify_nonce( $_POST['shifter_form_nonce_field'], 'shifter_form_nonce' ) ) {
			return $post_id;
		}
		// check for autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// get fields.
		$shifter_form_target       = isset( $_POST['shifter_form_target'] ) ? sanitize_text_field( $_POST['shifter_form_target'] ) : '';
		$shifter_form_action       = isset( $_POST['shifter_form_action'] ) ? sanitize_text_field( $_POST['shifter_form_action'] ) : '';
		$shifter_form_confirmation = isset( $_POST['shifter_form_confirmation'] ) ? sanitize_text_field( $_POST['shifter_form_confirmation'] ) : '';

		// update fields.
		update_post_meta( $post_id, 'shifter_form_target', $shifter_form_target );
		update_post_meta( $post_id, 'shifter_form_action', $shifter_form_action );
		update_post_meta( $post_id, 'shifter_form_confirmation', $shifter_form_confirmation );

		// form save hook.
		// used so you can hook here and save additional post fields added
		// via 'shifter_form_meta_data_output_end' or 'shifter_form_meta_data_output_end'.
		do_action( 'shifter_form_admin_save', $post_id );

	}



}

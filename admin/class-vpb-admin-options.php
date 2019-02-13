<?php

/**
 *
 * @link       www.visamultimedia.com
 * @since      1.0.0
 *
 * @package    Vpb
 * @subpackage Vpb/admin
 */


/**
 * The helper class for the public-facing functionality of the plugin.
 *
 * @package    Vpb
 * @subpackage Vpb/public
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Vpb_Admin_Options {

	/**
	 * Helper class
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $options
	 */
	public $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->options = get_option( 'vpb_options' );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_add_options_page() {
		add_options_page( __('Visa PassePartout Booking', 'visa-passepartout-booking'), __('Visa PassePartout Booking', 'visa-passepartout-booking'), 'manage_options', 'vpb', array( $this, 'vpb_options_page' ) );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_options_page() {
		include_once 'partials/vpb-admin-display.php';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_init_options() {
		register_setting( 'vpb_options', 'vpb_options', array( $this, 'vpb_options_validate' ) );
		
		add_settings_section( 'vpb_main', __('Main Settings', 'visa-passepartout-booking'), array( $this, 'vpb_main_section_text' ), 'vpb' );
		add_settings_field( 'vpb_url', __('URL base', 'visa-passepartout-booking'), array( $this, 'vpb_setting_url'), 'vpb', 'vpb_main' );
		add_settings_field( 'vpb_albergo', __('Albergo', 'visa-passepartout-booking'), array( $this, 'vpb_setting_albergo'), 'vpb', 'vpb_main' );
		add_settings_field( 'vpb_oid_portale_x_albergo', __('OidPortaleXAlbergo', 'visa-passepartout-booking'), array( $this, 'vpb_setting_oid_portale_x_albergo'), 'vpb', 'vpb_main' );

		add_settings_section( 'vpb_config', __('Configuration Settings', 'visa-passepartout-booking'), array( $this, 'vpb_config_section_text' ), 'vpb' );
		add_settings_field( 'vpb_min_nights', __('Minimum nights stay', 'visa-passepartout-booking'), array( $this, 'vpb_setting_min_nights'), 'vpb', 'vpb_config' );
		add_settings_field( 'vpb_max_rooms', __('Maximum bookable rooms', 'visa-passepartout-booking'), array( $this, 'vpb_setting_max_rooms'), 'vpb', 'vpb_config' );
		add_settings_field( 'vpb_max_people', __('Maximum people per room', 'visa-passepartout-booking'), array( $this, 'vpb_setting_max_people'), 'vpb', 'vpb_config' );
		add_settings_field( 'vpb_default_adults', __('Default adults per room', 'visa-passepartout-booking'), array( $this, 'vpb_setting_default_adults'), 'vpb', 'vpb_config' );
		add_settings_field( 'vpb_min_adults_first_room', __('Minimum adults in first room', 'visa-passepartout-booking'), array( $this, 'vpb_setting_min_adults_first_room'), 'vpb', 'vpb_config' );
		add_settings_field( 'vpb_min_adults_other_rooms', __('Minimum adults in other rooms', 'visa-passepartout-booking'), array( $this, 'vpb_setting_min_adults_other_rooms'), 'vpb', 'vpb_config' );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	function vpb_main_section_text() {
		echo '<p>' . __('Theese are the general settings', 'visa-passepartout-booking') . '</p>';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_setting_url() {
		echo "<input type='text' style='width:100%' id='vpb_url' name='vpb_options[url]' value='{$this->options['url']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_setting_albergo() {
		echo "<input type='text' id='vpb_albergo' name='vpb_options[albergo]' value='{$this->options['albergo']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_setting_oid_portale_x_albergo() {
		echo "<input type='text' id='vpb_oid_portale_x_albergo' name='vpb_options[oid_portale_x_albergo]' value='{$this->options['oid_portale_x_albergo']}' />";
	}


	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	function vpb_config_section_text() {
		echo '<p>' . __('Theese are the configuration settings', 'visa-passepartout-booking') . '</p>';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_setting_min_nights() {
		echo "<input type='number' step='1' min='1' id='vpb_min_nights' name='vpb_options[min_nights]' value='{$this->options['min_nights']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_setting_max_rooms() {
		echo "<input type='number' step='1' min='1' id='vpb_max_rooms' name='vpb_options[max_rooms]' value='{$this->options['max_rooms']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_setting_max_people() {
		echo "<input type='number' step='1' min='1' id='vpb_max_people' name='vpb_options[max_people]' value='{$this->options['max_people']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_setting_default_adults() {
		echo "<input type='number' step='1' min='1' id='vpb_default_adults' name='vpb_options[default_adults]' value='{$this->options['default_adults']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_setting_min_adults_first_room() {
		echo "<input type='number' step='1' min='1' id='vpb_min_adults_first_room' name='vpb_options[min_adults_first_room]' value='{$this->options['min_adults_first_room']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vpb_setting_min_adults_other_rooms() {
		echo "<input type='number' step='1' min='1' id='vpb_min_adults_other_rooms' name='vpb_options[min_adults_other_rooms]' value='{$this->options['min_adults_other_rooms']}' />";
	}


	/**
	 * Undocumented function
	 *
	 * @param mixed $input
	 * @return mixed
	 */
	public function vpb_options_validate( $input ) {
		
		return $input;
	}
}

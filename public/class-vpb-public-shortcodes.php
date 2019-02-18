<?php

/**
 * The shortcodes class for the public-facing functionality of the plugin.
 *
 * @link       www.visamultimedia.com
 * @since      1.0.0
 *
 * @package    Vpb
 * @subpackage Vpb/public
 */

/**
 * The helper class for the public-facing functionality of the plugin.
 *
 * @package    Vpb
 * @subpackage Vpb/public
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Vpb_Public_Shortcodes {

	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->options = get_option( 'vpb_options' );
		$this::add_shortocdes();
	}

	/**
	 * Undocumented function
	 *
	 * @since    1.0.0
	 */
	public function add_shortocdes() {

		add_shortcode( 'vpb_display_form', array( $this, 'vpb_display_form' ) );

	}

	/**
	 * Undocumented function
	 * 
	 * @since    1.0.0
	 *
	 * @param [type] $atts
	 * @return void
	 */
	public function vpb_display_form( $atts ){
		$atts = shortcode_atts(
            array(),
			$atts,
			'vpb_display_form'
		);

		ob_start();
		?>

		<div id="vpb" class="clearfix" ng-app="vpb" ng-controller="vpbController" ng-cloak ng-strict-di>

			<form name="vpbForm" novalidate>

				<div class="vpb_dates clearfix">
					<div class="vpb_date vpb_date_arrival clearfix">
						<label><?= __( 'Arrival date', 'visa-passepartout-booking' ) ?></label>
						<input name="arrivalDate" type="date" ng-model="form.arrivalDate" ng-min="{{internal.minArrivalDate}}" min="{{internal.minArrivalDate | date:'yyyy-MM-dd'}}" required>
						<label class="validation-error" ng-if="vpbForm.arrivalDate.$invalid"><?= __( 'Invalid date!', 'visa-passepartout-booking' ) ?></label>
					</div>
					<div class="vpb_date vpb_date_depart clearfix">
						<label><?= __( 'Departure date', 'visa-passepartout-booking' ) ?></label>
						<input name="departDate" type="date" ng-model="form.departDate" ng-min="{{internal.minDepartDate}}" min="{{internal.minDepartDate | date:'yyyy-MM-dd'}}" required>
						<label class="validation-error" ng-if="vpbForm.departDate.$invalid"><?= __( 'Invalid date!', 'visa-passepartout-booking' ) ?></label>
					</div>
				</div>

				<div class="vpb_rooms_controls clearfix">
					<label><?= __( 'Rooms', 'visa-passepartout-booking' ) ?></label>
					<input type="button" ng-click="removeRoom()" ng-disabled="form.rooms.length == 1" value="<?= __( '-', 'visa-passepartout-booking' ) ?>" />
					<input type="number" name="totalRooms" value="{{form.rooms.length}}" readonly/>
					<input type="button" ng-click="addRoom()" ng-disabled="form.rooms.length >= internal.maxRooms" value="<?= __( '+', 'visa-passepartout-booking' ) ?>" />					
				</div>

				<div class="vpb_rooms clearfix">
					<div ng-repeat="x in form.rooms" class="vpb_room clearfix">
						<div class="people clearfix">
							<label><?= __( 'Room ', 'visa-passepartout-booking' ) ?>{{(x.id) + 1}}</label>
							<div class="adults clearfix">
								<label><?= __( 'Adults', 'visa-passepartout-booking' ) ?></label>
								<select ng-model="x.adulti" ng-options="n for n in [] | range:x.minAdulti:(x.maxAdulti - x.bambini)"></select>
							</div>
							<div class="children clearfix">
								<label><?= __( 'Children', 'visa-passepartout-booking' ) ?></label>
								<select ng-model="x.bambini" ng-options="n for n in [] | range:x.minBambini:(x.maxBambini - x.adulti)"></select>
							</div>
						</div>
					</div>
				</div>

				<div class="vpb_submit clearfix">
					<input type="submit" ng-click="submitForm()" ng-disabled="vpbForm.$invalid" value="<?= __( 'Submit', 'visa-passepartout-booking' ) ?>" />
					<label class="validation-error" ng-if="vpbForm.$invalid"><?= __( 'There are one or more errors in your request. Please correct them before submitting.', 'visa-passepartout-booking' ) ?></label>
				</div>
			</form>

		</div>		

		<?php
		return ob_get_clean();
	}

}

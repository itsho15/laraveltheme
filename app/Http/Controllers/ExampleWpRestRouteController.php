<?php
namespace App\Http\Controllers;

class ExampleWpRestRouteController extends Controller {
	protected $helper;

	/**
	 * Create a new controller instance.
	 * @param $helper LumenHelper
	 */
	public function __construct() {
		//$this->helper = $helper;
	}
	/**
	 * Create a new controller instance.
	 * @return \WP_REST_Response
	 */
	public function get() {
		//return rest_ensure_response(array('batot' => 'bata'));
	}
}

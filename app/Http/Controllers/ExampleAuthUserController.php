<?php
namespace App\Http\Controllers;

class ExampleAuthUserController extends Controller {
	protected $helper, $request, $auth;

	/**
	 * Create a new controller instance.
	 */
	public function __construct(WpHelper $WpHelper) {
		$this->WpHelper = $WpHelper;
	}

	public function show() {

		echo ('<p>Hello ' . auth()->user()->display_name . '</p>');
		echo ('<p>Hello ' . auth()->user()->display_name . '</p>');

	}
}

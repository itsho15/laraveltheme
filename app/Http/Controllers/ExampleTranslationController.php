<?php namespace App\Http\Controllers;

class ExampleTranslationController extends Controller {
	protected $helper, $translator;

	/**
	 * Create a new controller instance.
	 */
	public function __construct() {

	}

	public function show() {
		//echo $this->translator->trans('talk.test');
	}
}

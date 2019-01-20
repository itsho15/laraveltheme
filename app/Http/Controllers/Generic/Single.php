<?php

namespace App\Http\Controllers\Generic;

use App\Http\Controllers\Controller;
use App\Models\WpPost;

class Single extends Controller {
	/**
	 * Single constructor.
	 */
	public function __construct() {
		if (!empty($GLOBALS['post'])) {
			setup_postdata($GLOBALS['post']);
		}
	}

	public function index() {
		$categories = get_the_category();
		$post       = WpPost::find(get_the_ID());
		return $this->view('generic.single', compact('post', 'categories'));
	}
}
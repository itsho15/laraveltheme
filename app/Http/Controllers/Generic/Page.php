<?php

namespace App\Http\Controllers\Generic;

use App\Http\Controllers\Controller;
use App\Model\WpPost;

class Page extends Controller {
	/**
	 * Page constructor.
	 */
	public function __construct() {
		if (!empty($GLOBALS['post'])) {
			setup_postdata($GLOBALS['post']);
		}
	}

	public function index() {
		$data = [
			'post' => new WpPost(),
		];

		return $this->view('generic.page', $data);
	}
}
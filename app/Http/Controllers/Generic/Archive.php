<?php

namespace App\Http\Controllers\Generic;

use App\Http\Controllers\Controller;
use App\Models\WpPost;

class Archive extends Controller {
	public function index() {
		$data = [
			'posts' => WpPost::queriedPosts(), // get the posts for current page
		];

		return $this->view('generic.archive', $data);
	}
}
<?php

namespace App\Http\Controllers\Generic;

use App\Http\Controllers\Controller;

class Test extends Controller {
	public function index() {

		return $this->view('generic.test');
	}
}
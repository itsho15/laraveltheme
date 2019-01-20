<?php namespace App\Http\Controllers;

class ExampleCacheController extends Controller {
	protected $helper, $cache;

	/**
	 * Create a new controller instance.
	 */
	public function __construct() {

		$this->cache = cache();
	}

	public function show() {

		if (!$this->cache->has('test')) {
			$this->cache->put('test', 'Hello World! I am cached.', 60);
		}

		echo $this->cache->get('test');
	}
}

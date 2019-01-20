<?php namespace App\Widgets;
use App\Models\WpPost;
use App\Widget;

class FrontEndWidget extends \WP_Widget {

	protected $helper, $post, $cache;

	function __construct() {

		$this->post = new WpPost;

		parent::__construct(
			'wp_lumen_widget',
			'Lumen Widget',
			array(
				'classname'   => 'wp_lumen_list_child_pages',
				'description' => 'List Child Pages for the current page',
			)
		);
	}

	public function form($instance) {
		echo '<p>Controls</p>'; //Expects at least one paragraph.
	}

	public function widget($args, $instance) {
		$request = request();

		//echo $this->helper->view('widgets.widget');
		echo view('widgets.widget1');
	}

	public function update($new_instance, $old_instance) {

		return $new_instance;
	}
}
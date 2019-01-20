<?php
namespace App\Http\Controllers;
use App\Models\WpPost;

class ExampleMetaBoxController extends Controller {

	public function __construct(WpPost $post) {
		$this->post    = $post;
		$this->request = request();
	}
	public function template($post, $metabox_attributes) {
		$post = $this->post->find($post->ID);
		return view('meta_box', compact('post', 'metabox_attributes'));
	}

	public function save($post, $post_id, $update) {

		//The user is allowed to update the post...
		if ($this->request->filled('lumen_meta_test')) {

			$this->post = $this->post->with('meta')->find($post_id);

			if ($this->post->meta()->where('meta_key', 'lumen_meta_test')->exists()) {
				$this->post->meta()->where('meta_key', 'lumen_meta_test')->update(array(
					'meta_value' => $this->request->get('lumen_meta_test'),
				));
			} else {
				$this->post->meta()->create(array(
					'meta_key'   => 'lumen_meta_test',
					'meta_value' => $this->request->get('lumen_meta_test'),
				));
			}

			//$newpost = new WpPost();
			//$newpost->post_title = str_random(16);
			//$newpost->post_name = str_random(16);
			//$newpost->post_author = 1;
			//$newpost->save();
			//$newpost->attachTaxonomy(22);
			//$newpost->detachTaxonomy(22);
		}
	}

}

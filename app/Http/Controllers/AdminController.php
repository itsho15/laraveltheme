<?php namespace App\Http\Controllers;

use App\Models\WpPost;

class AdminController extends Controller {

	private $post, $request, $auth, $helper;

	/**
	 * Create a new controller instance.
	 * @param $helper LumenHelper
	 * @param $post WpPost
	 */
	public function __construct(WpPost $post) {
		$this->post = $post;

		$this->request = request();
		$this->auth    = auth();
	}

	public function template() {

		//Get Paginated Data from Database
		$this->post = $this->post
			->where('post_status', 'Publish')
			->whereIn('post_type', ['page', 'post'])
			->orderBy('post_title', 'asc')
			->paginate($items = 1, $columns = ['*'], $pageName = 'pagination_page', $this->request->get('pagination_page'))
			->setPath($this->request->url())
			->appends($this->request->only('page'));

		return $this->helper->view('admin-page-posts', array(
			'posts'   => $this->post,
			'request' => $this->request,
		));
	}
}
<?php

namespace App\Http\Controllers;

use App\Helpers\WpHelper;
use App\Models\Time;
use App\Models\WpPost;
use App\Traits\WpPageEnabled;

class ExampleRouteThemeViewController extends Controller {
	protected $helper, $vehicle, $post, $auth;
	use WpPageEnabled;
	/**
	 * Create a new controller instance.
	 */
	public function __construct(WpPost $post, WpHelper $WpHelper) {

		$this->setPageTitle('Test Theme');
		$this->helper   = $helper;
		$this->post     = $post;
		$this->request  = request();
		$this->wpHelper = $WpHelper;
		$this->auth     = auth();

		$this->wpHelper->addMenuLink(2, 'title', 2);

		//$WpHelper->addMenuLink($post->ID, $post->title, $menu_id, $parent = 0);

	}
	public function showMenu() {

		return '<a href="test">test</>';
	}

	public function show() {

		$helper = $this->helper;
		return $this->helper->view('test-theme', compact('helper'));
	}

	public function store() {

		$this->validate($this->request,
			[
				'start' => 'required',
				'end'   => 'required',
				'note'  => 'required',
			], [], [
				'start' => trans('admin.start'),
				'end'   => trans('admin.end'),
				'note'  => trans('admin.note'),
			]);

		$end = $this->request->get('end');

		$checkforExsists = Time::where(function ($query) use ($end) {
			$query->where('start', '<=', $this->request->get('start'))
				->where('end', '>', $this->request->get('start'));
		})
			->orWhere(function ($query) use ($end) {
				$query->where('start', '>=', $end)
					->where('end', '<', $end);
			})->count();

		if ($checkforExsists) {
			$this->helper->session()->flash('error', 'please choose other date this date allready used');
			return $this->helper->redirect(url('times'));
		} else {

			Time::create([
				'start'     => $this->request->get('start'),
				'end'       => $end,
				'note'      => $this->request->get('note'),
				'classname' => $this->request->get('classname'),
				'user_id'   => $this->auth->user()->id,

			]);

			$this->helper->session()->flash('success', trans('admin.time_created'));
			return $this->helper->redirect(url('times'));
		}
	}
}

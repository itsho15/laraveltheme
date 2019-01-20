<?php

namespace App\Providers;

use Laraish\Options\OptionsForm;
use Laraish\Options\OptionsPage;
use Laraish\WpSupport\Providers\ThemeOptionsProvider as ServiceProvider;

class ThemeOptionsProvider extends ServiceProvider {
	public function boot() {

		parent::boot();
		$optionsPage = new OptionsPage([
			'menuSlug'       => 'my_options_page',
			'menuTitle'      => 'My Options Page',
			'pageTitle'      => 'My Options Page',
			'optionGroup'    => 'my_options_page',
			'iconUrl'        => 'dashicons-welcome-learn-more',
			'optionName'     => 'my_options',
			'renderFunction' => function (OptionsPage $page, OptionsForm $form) {
				echo view('admin.options', compact('page', 'form'));
			},
			'scripts'        => [public_url('admin/js/FileFieldGenerator.js'), public_url('admin/js/MediaFieldGenerator.js'), public_url('admin/js/selectFieldGenerator.js'), public_url('admin/js/selectize.js')],
			'styles'         => [public_url('admin/css/sharedStyle.css'), public_url('admin/css/media.css')],
		]);
		$optionsPage->register();
	}
}

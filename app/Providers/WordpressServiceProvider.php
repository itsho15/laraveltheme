<?php
namespace App\Providers;
use App\Helpers\WpHelper;
use Illuminate\Support\ServiceProvider;

class WordpressServiceProvider extends ServiceProvider {

	private $wpHelper;

	/**
	 * WordpressServiceProvider constructor.
	 * @param $app \Illuminate\Contracts\Foundation\Application
	 */
	public function __construct($app) {

		parent::__construct($app);

		$this->wpHelper = new WpHelper;

	}

	/**
	 * Register any application services.
	 * @return void
	 */
	public function register() {

		/** Add FrontEnd Widget **/
		$this->wpHelper
			->addWidget(
				\App\Widgets\FrontEndWidget::class
			);

		$this->wpHelper->register_sidebar(
			[
				'name'          => __('Main Sidebar', 'theme-slug'),
				'id'            => 'sidebar-1',
				'description'   => __('Widgets in this area will be shown on all posts and pages.', 'theme-slug'),
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget'  => '</li>',
				'before_title'  => '<h2 class="widgettitle">',
				'after_title'   => '</h2>',
			]

		);

		/** Add Admin Bar Nodes
		$this->wpHelper
		->addAdminBarNode(
		false,
		'lumen_bar_node2',
		'Lumen Bar Node',
		'#'
		)->addAdminBarNode(
		'lumen_bar_node2',
		'lumen_bar_node2_child1',
		'Node Child 1',
		'#'
		)->addAdminBarNode(
		'lumen_bar_node2',
		'lumen_bar_node2_child2',
		'Node Child 2',
		'#'
		)->addAdminBarNode(
		'lumen_bar_node2',
		'lumen_bar_node2_child3',
		'Node Child 2',
		'#'
		);
		 **/

		/** Add Shortcodes **/
		$this->wpHelper
			->addShortcode(
				'auth_register',
				function ($parameters, $content) {
					return $this->app->call('\App\Http\Controllers\Auth\RegisterShortcodeController@template', compact('parameters', 'content'));
				}
			)
			->addShortcode(
				'auth_login',
				function ($parameters, $content) {
					return $this->app->call('\App\Http\Controllers\Auth\LoginShortcodeController@template', compact('parameters', 'content'));
				}
			)->addShortcode(
			'submssions',
			function ($parameters, $content) {
				//return $this->app->call('\App\Http\Controllers\SubmssionsShortcodeController@template', compact('parameters', 'content'));
			}
		);

		/** Add MetaBoxes **/
		$this->wpHelper
			->addMetaBox(
				'example_meta_box',
				'Example Meta Box',
				function ($post, $metabox_attributes) {
					return response($this->app->call('\App\Http\Controllers\MetaBoxController@template', compact('post', 'metabox_attributes')))
						->sendContent();
				},
				['post', 'page'],
				'normal',
				'default',
				2
			)
			->addAction(
				'save_post',
				function ($post_id, $post, $update) {
					if ($post->post_type == 'post') {
						$this->app->make('cache')->flush();
						$this->app->call('\App\Http\Controllers\MetaBoxController@save', compact('post_id', 'post', 'update'));
					}
				},
				10,
				3
			);

		/** Add Nav Menu MetaBoxes */
		$this->wpHelper->addMetaBox(
			'example_menu_meta_box',
			'Custom Routes',
			function ($object, $arguments) {
				return
				response($this->app->call('\App\Http\Controllers\GlobalController@AddLinksToMenu', compact('object', 'arguments')))
					->sendContent();
			},
			'nav-menus',
			'side',
			'default',
			2
		);

		/** Add Dashboard Widget **/

		$this->wpHelper
			->addDashboardWidget(
				'example_admin_widget',
				'Example Admin Widget',
				function () {
					return
					response($this->app->call('\App\Widgets\AdminWidget@template'))
						->sendContent();
				}
			);

		/** Add WP Rest API Route
		$this->wpHelper
		->addRestRoute('wp-lumen/api/v1', '/test', array(
		'methods'  => ['get'],
		'callback' => function () {
		return $this->app->call('\App\Http\Controllers\ExampleWpRestRouteController@get');
		},
		));
		 **/

		/** Add Dashboard Panels
		$this->wpHelper
		->addAdminPanel(
		'NTSCUserSubmission',
		'NTSC User Submission',
		'NTSC User Submission',
		function () {
		return response($this->app->call('\App\Http\Controllers\GlobalController@Tabs'))
		->sendContent();

		},
		'manage_options'
		)->addAdminSubPanel(
		'NTSCUserSubmission',
		'lumen_settings',
		'Shortcodes',
		'Shortcodes',
		function () {
		return
		response($this->app->call('\App\Http\Controllers\SettingsController@template'))
		->sendContent();
		},
		'manage_options'
		)->addAdminSubPanel(
		'NTSCUserSubmission',
		'import_export',
		'import/export',
		'import/export',
		function () {
		return
		response($this->app->call('\App\Http\Controllers\SettingsController@importExport'))
		->sendContent();
		},
		'manage_options'
		);


		/** Add CSS & Scripts **/
		/** Add CSS & Scripts **/
		//$this->wpHelper
		//->enqueueStyle('prefix_bootstrapcssModel', 'path_here', array(), '1.0.0', 'all', 'admin')
		//->enqueueScript('mainfrontjs', 'path_here', array('jquery'), '1.0.0', true, 'admin');
	}
}

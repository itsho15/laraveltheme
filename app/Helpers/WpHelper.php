<?php
namespace App\Helpers;

class WpHelper {

	/**
	 * Adds Page to a WordPress NavMenu
	 * @param int $page_id (The ID of the page you want to add)
	 * @param string $page_title (Title of menu item)
	 * @param int $menu_id  (NavMenu ID)
	 * @param int $parent  (Optional - Menu item Parent ID)
	 * @return self
	 */
	function addMenuLink($page_id, $page_title, $menu_id, $parent = 0) {
		wp_update_nav_menu_item($menu_id, 0, array(
			'menu-item-title'     => $page_title,
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $page_id,
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
			'menu-item-parent-id' => $parent,
		));
		return $this;
	}

	/**
	 * Add Nav menu to the plugin
	 * @param array $navlinks (array to passing the links on it example 'key' => 'value' )
	 * @param string $titleHeader (Title of the page)
	 * @param string $pagename  (the name after admin.php?page=)
	 * @param string $default  (default active menu use the key of $navlinks any key of them to make it active)
	 * @param url $action (the url of action of form)
	 * @param string $method (method of the post by default it`s post method)
	 * @param function $callbackfunction (callback function to render the content of each nav)
	 * @return self
	 */

	public function AddTabsPanel($navlinks = array(), $titleHeader = null, $pagename, $default, $callbackfunction) {

		$active_tab = isset($_GET['tab']) ? $_GET['tab'] : $default;

		?>
	    <!-- Create a header in the default WordPress 'wrap' container -->
	    <div class="wrap">

        <div id="icon-themes" class="icon32"></div>

        <?php if ($titleHeader != null) {
			echo "<h2>{$titleHeader}</h2>";
		}
		?>

        <?php settings_errors();?>

	        <h2 class="nav-tab-wrapper">
	        	<?php foreach ($navlinks as $key => $value) {
			?>
	        		<a href="?page=<?php echo $pagename; ?>&tab=<?php echo $key; ?>" class="nav-tab <?php echo $active_tab == $key ? 'nav-tab-active' : ''; ?>"><?php echo $value; ?></a>
	        	<?php }

		?>
	        </h2>

	    <?php echo $callbackfunction ?>

	    </div><!-- /.wrap -->
	<?php
}

	/**
	 * Add REST API Route
	 * @param string $namespace
	 * @param string $route
	 * @param array|string $methods
	 * @param array $options
	 * @return self
	 */
	public function addRestRoute($namespace, $route, $options = array()) {
		$methods   = [];
		$methodMap = array(
			'get'    => \WP_REST_Server::READABLE,
			'post'   => \WP_REST_Server::CREATABLE,
			'put'    => \WP_REST_Server::EDITABLE,
			'patch'  => \WP_REST_Server::EDITABLE,
			'delete' => \WP_REST_Server::DELETABLE,
			'all'    => \WP_REST_Server::ALLMETHODS,
		);
		foreach ($options['methods'] as $method) {
			array_push($methods, $methodMap[$method]);
		}
		$options['methods'] = $methods;
		add_action('rest_api_init', function () use ($namespace, $route, $methods, $options) {
			register_rest_route($namespace, $route, $options);
		});
		//add_action('rest_api_init', function() {
		//    register_rest_route( 'wp-lumen/api/v1', '/phrase', array(
		//        'methods'  => WP_REST_Server::ALLMETHODS,
		//        'callback' => function() {
		//            return rest_ensure_response(array('test'=>'Hello World, this is the WordPress REST API' ));
		//        },
		//    ));
		//});
		return $this;
	}

	/**
	 * Add Shortcode
	 * @param string $tag
	 * @param string $class
	 * @return self
	 */
	public function addShortcode($tag, \Closure $closure) {
		add_shortcode($tag, $closure);
		return $this;
	}

	/**
	 * Add Admin Notice
	 * @param \Closure $closure
	 * @return self
	 */
	public function addAdminNotice(\Closure $closure) {
		add_action('admin_notices', $closure);
		return $this;
	}

	/**
	 * Add Shortcode
	 * @param string $id
	 * @param string $title
	 * @param \Closure $closure
	 * @param string $screen post|page|custom_postType.,
	 * @param string $context normal|side|advanced,
	 * @param string $priority default|high|low,
	 * @param integer $closure_args
	 * @return self
	 */
	public function addMetaBox($id, $title, $closure, $screen = 'post', $context = 'normal', $priority = 'default', $closure_args = 1) {
		if (!is_admin()) {
			return $this;
		}

		switch ($screen) {
		case 'nav-menus':
			$action = 'admin_head-nav-menus.php';
			break;
		default:
			$action = 'add_meta_boxes';
			break;
		}
		add_action($action, function () use ($id, $title, $closure, $screen, $context, $priority, $closure_args) {
			add_meta_box($id, $title, $closure, $screen, $context, $priority, $closure_args);
		});
		return $this;
	}

	/**
	 * Add Widget
	 * @param string $class
	 * @return self
	 */
	public function addWidget($class) {
		add_action('widgets_init', function () use ($class) {
			register_widget($class);
		});
		return $this;
	}

	public function register_sidebar($data) {

		add_action('widgets_init', function () use ($data) {
			register_sidebar($data);
		});
		return $this;
	}

	/**
	 * Add Widget
	 * @param string $id
	 * @param string $name
	 * @param string $closure
	 * @return self
	 */
	public function addDashboardWidget($id, $name, $closure) {
		if (!is_admin()) {
			return $this;
		}

		add_action('wp_dashboard_setup', function () use ($id, $name, $closure) {
			wp_add_dashboard_widget(
				$id,
				$name,
				$closure
			);
		});
		return $this;
	}

	/**
	 * Add Admin Panel
	 * @param string $menu_title
	 * @param string $menu_slug
	 * @param string $page_title
	 * @param string $closure
	 * @param string|array $capability
	 * @return self
	 */
	public function addAdminPanel($menu_slug, $menu_title, $page_title, $closure, $capability = array('manage_options')) {
		if (!is_admin()) {
			return $this;
		}

		add_action('admin_menu', function () use ($menu_slug, $page_title, $menu_title, $capability, $closure) {
			add_menu_page(
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$closure
			);
		});
		return $this;
	}
	/**
	 * Add Admin Panel
	 * @param string $parent_slug
	 * @param string $menu_title
	 * @param string $menu_slug
	 * @param string $page_title
	 * @param string $closure
	 * @param string|array $capability
	 * @return self
	 */
	public function addAdminSubPanel($parent_slug, $menu_slug, $menu_title, $page_title, $closure, $capability = array('manage_options')) {
		if (!is_admin()) {
			return $this;
		}

		add_action('admin_menu', function () use ($parent_slug, $menu_slug, $menu_title, $page_title, $closure, $capability) {
			add_submenu_page(
				$parent_slug,
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$closure
			);
		});
		return $this;
	}

	/**
	 * Add Action
	 * @param string $action
	 * @param \Closure $closure
	 * @param integer $priority
	 * @return self
	 */
	public function addAction($action, \Closure $closure, $priority = 10, $closure_arguments = 0) {
		add_action($action, $closure, $priority, $closure_arguments);
		return $this;
	}

	/**
	 * Add Admin Bar Node
	 * @param string $id
	 * @param string $title
	 * @param string $href
	 * @param array $attributes
	 * @return self
	 */
	public function addAdminBarNode($parent = false, $id, $title, $href, $group = false, $meta = array()) {
		add_action('admin_bar_menu', function ($wp_admin_bar) use ($parent, $id, $title, $href, $group, $meta) {
			$wp_admin_bar->add_node(array(
				'parent' => $parent,
				'id'     => $id,
				'title'  => $title,
				'href'   => $href,
				'group'  => $group,
				'meta'   => $meta,
			));
		}, 10000);
		return $this;
	}

	/**
	 * Enqueue Style
	 * @param string $handle
	 * @param string $src
	 * @param array $dependencies
	 * @param string $version
	 * @param string $media [all|screen|print]
	 * @return self
	 */
	public function enqueueStyle($handle, $src, $dependencies = array(), $version = '1.0.0', $media = 'all', $admin = null) {
		if ($admin == null || $admin == 'front-end') {
			add_action('wp_enqueue_scripts', function () use ($handle, $src, $dependencies, $version, $media) {
				wp_enqueue_style($handle, $src, $dependencies, $version, $media);
			});
		} else {
			add_action('admin_enqueue_scripts', function () use ($handle, $src, $dependencies, $version, $media) {
				wp_enqueue_style($handle, $src, $dependencies, $version, $media);
			});
		}

		return $this;
	}
	/**
	 * Enqueue Script
	 * @param string $handle
	 * @param string $src
	 * @param array $dependencies
	 * @param string $version
	 * @param boolean $inFooter
	 * @return self
	 */
	public function enqueueScript($handle, $src, $dependencies = array(), $version = '1.0.0', $inFooter = true, $admin = null) {

		if ($admin == null || $admin == 'front-end') {
			add_action('wp_enqueue_scripts', function () use ($handle, $src, $dependencies, $version, $inFooter) {
				wp_enqueue_script($handle, $src, $dependencies, $version, $inFooter);
			});
		} else {
			add_action('admin_enqueue_scripts', function () use ($handle, $src, $dependencies, $version, $inFooter) {
				wp_enqueue_script($handle, $src, $dependencies, $version, $inFooter);
			});
		}
		return $this;
	}

	/**
	 * Get Wp Global Post Object
	 * @return \WP_Post
	 */
	public function getGlobalPost() {
		global $post;
		return $post;
	}

	/**
	 * Get WP Database
	 * @return array
	 */
	public static function getWpDatabaseConnection() {
		global $wpdb;
		return [
			'driver'                  => 'mysql',
			'host'                    => DB_HOST,
			'database'                => DB_NAME,
			'username'                => DB_USER,
			'password'                => DB_PASSWORD,
			'charset'                 => $wpdb->charset,
			'collation'               => $wpdb->collate,
			'prefix'                  => $wpdb->prefix,
			'foreign_key_constraints' => true,
			'timezone'                => '+00:00',
			'strict'                  => false,
			'engine'                  => 'InnoDB',
		];
	}

}

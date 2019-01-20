<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class DatabaseController extends Controller {
	/*

		protected $helper, $request, $panel, $database, $files, $tables, $schema, $wp;

		public function __construct(LumenHelper $helper, WpHelper $wp) {

			$this->panel    = 'DatabaseInstall';
			$this->wp       = $wp;
			$this->helper   = $helper;
			$this->request  = $this->helper->request();
			$this->database = $this->helper->make('db');
			$this->files    = $this->helper->make('files');
			$this->schema   = $this->database->getSchemaBuilder();
			$this->data();
			$this->template();
		}

		public function data() {
			//Table Definitions & Schema Migration Callbacks
			$this->tables = (object) [
				'api_leads_entries'   => (object) [
					'status'  => false,
					'install' => function ($table) {
						 //@var $table \Illuminate\Database\Schema\Blueprint
						$table->increments('id');
						$table->longText('request')->nullable();
						$table->string('status', 191)->nullable()->default('null');
						$table->timestamps();
					},
				],
				'api_leads_locations' => (object) [
					'status'  => false,
					'install' => function ($table) {
						@var $table \Illuminate\Database\Schema\Blueprint
						$table->increments('id');
						$table->float('lat', 11, 8);
						$table->float('lng', 11, 8);
						$table->index(['lat', 'lng']);
						$table->string('city', 191)->nullable()->default('null');
						$table->string('county', 191)->nullable()->default('null');
						$table->string('state', 191)->nullable()->default('null');
						$table->string('zip', 5)->nullable()->default('null');
					},
					'seed'    => [
						'model' => \App\Models\Location::class,
						'chunk' => 100,
						'path'  => database_path('seeds/locations.php'),
					],
				],
			];

			//Migrate, Drop or Refresh Table Schema
			if ($this->request->has('action') && $this->request->has('table')) {

				$table  = $this->request->get('table');
				$action = $this->request->get('action');

				//Drop Table
				if (in_array($action, array('refresh', 'drop'))) {
					$this->schema->dropIfExists($table);
				}

				//Create Table
				if (in_array($action, array('install', 'refresh'))) {
					$this->schema->create($table, $this->tables->$table->install);
				}

				//Seed Table
				if (in_array($action, array('install', 'refresh')) && isset($this->tables->$table->seed)) {

					$path  = $this->tables->$table->seed['path'];
					$model = $this->tables->$table->seed['model'];

					//Get the array from the file.
					$entries = collect($this->files->getRequire($path));

					//Break the array into chunks.
					$chunks = $entries->chunk($this->tables->$table->seed['chunk'])->toArray();

					//Insert the chunks into the database.
					$this->database->transaction(function () use ($chunks, $model) {
						foreach ($chunks as $chunk) {
							app($model)->insert($chunk);
						}
					});
				}

				//Flush Table
				if (in_array($action, array('flush'))) {
					$this->database->table($table)->delete();
				}

				//Redirect

				wp_redirect(admin_url('admin.php?page=DatabaseInstall', 'http'), 301);
				exit;

			}

			//Get the status of each table.
			foreach (get_object_vars($this->tables) as $key => $value) {
				if ($this->schema->hasTable($key)) {
					$this->tables->$key->status = "{$this->database->table($key)->count()} Rows";
				}
			}
		}

		public function template() {
			return $this->helper->view('admin.database', array(
				'tables' => (array) $this->tables,
				'panel'  => $this->panel,
			));
		}
	*/

}
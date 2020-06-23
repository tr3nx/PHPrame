<?php

namespace Core;

use Core\Http\Router;
use Core\Http\Request;
use Core\Http\Response;
use Core\Database\DB;

class App {
	public $config;
	public $router;

	public function __construct($config) {
		session_start();

		$this->config = $config;
		$this->router = new Router($this->config['routes']);

		(new DB)->connect($this->config['database']['dsn'], true);

		// $GLOBALS['app'] = $this;
	}

	public function execute() {
		$request = new Request();
		$response = new Response();

		[$controller, $method] = explode('::', $this->router->parse($request->uri));
		return $response->respond((new $controller)->{$method}($request, $response));
	}
}

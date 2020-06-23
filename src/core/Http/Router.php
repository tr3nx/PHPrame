<?php

namespace Core\Http;

class Router {
	private $routes;

	public function __construct($routes) {
		$this->routes = $routes;
	}

	public function parse($uri) {
		if (array_key_exists($uri, $this->routes)) {
			return $this->routes[$uri];
		}

		foreach ($this->routes as $routePath => $routeCall) {
			if (strpos($routePath, '(') !== false) {
				$varname = explode(':', substr($routePath, strpos($routePath, '(') + 1, strpos($routePath, ')') - 1))[0];
				$routeRegex = str_replace('/', '\/', str_replace("{$varname}:", '', $routePath));

				if (preg_match("/^{$routeRegex}\/?$/", $uri, $matches) && count($matches)) {
					$_GET[$varname] = sanitize(array_slice($matches, 1)[0]);
					return $routeCall;
				}
			}
		}

		return $this->routes['/404'];
	}
}

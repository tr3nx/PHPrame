<?php

namespace Core\Http;

class Request {
	public $uri;
	public $method;
	public $query;
	public $ip;
	public $agent;
	public $referer;

	public function __construct() {
		$this->uri     = $this->server('REQUEST_URI');
		$this->method  = $this->server('REQUEST_METHOD');
		$this->query   = $this->server('QUERY_STRING');
		$this->ip      = $this->server('REMOTE_ADDR');
		$this->agent   = $this->server('HTTP_USER_AGENT');
		$this->referer = $this->server('HTTP_REFERER');
	}

	public function get($var, $sanitize = true) {
		return $this->retrieve($_GET, $var, $sanitize);
	}

	public function post($var, $sanitize = true) {
		return $this->retrieve($_POST, $var, $sanitize);
	}

	public function server($var, $sanitize = true) {
		return $this->retrieve($_SERVER, $var, $sanitize);
	}

	public function session($var, $sanitize = true) {
		return $this->retrieve($_SESSION, $var, $sanitize);
	}

	private function retrieve($data, $var, $sanitize = true) {
		if ( ! array_key_exists($var, $data)) { return null; }
		return $sanitize ? sanitize($data[$var]) : $data[$var];
	}
}

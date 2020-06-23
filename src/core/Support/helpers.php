<?php

if ( ! function_exists('d')) {
	function d($var) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
}

if ( ! function_exists('dd')) {
	function dd($var) {
		d($var);
		die();
	}
}

if ( ! function_exists('env')) {
	function env($key, $default = null) {
		return getenv($key) ?: $default;
	}
}

if ( ! function_exists('toJson')) {
	function toJson($data) {
		return ($json = json_encode($data)) ?: '{}';
	}
}

if ( ! function_exists('isJson')) {
	function isJson($buffer) {
		if (isset($buffer) && ! empty($buffer)) {
			return ($buffer[0] == '{' && $buffer[-1] == '}') || ($buffer[0] == '[' && $buffer[-1] == ']');
		}
		return false;
	}
	// json_decode($buffer);
	// return (json_last_error() == JSON_ERROR_NONE);
}

if ( ! function_exists('pather')) {
	function pather($paths, $relative = false) {
		if ( ! is_array($paths)) { return $paths; }
		if (count($paths) <= 1) { return array_pop($paths); }
		$path = implode('/', array_map(function($item) { return trim($item, '/'); }, $paths));
		return $relative ? $path : '/' . $path;
	}
}

if ( ! function_exists('sanitize') && ! function_exists('_sanitize')) {
	function sanitize($vs) {
		if ( ! is_array($vs)) { return _sanitize($vs); }
		return array_map(function($v) { return sanitize($v); }, $vs);
	}
	function _sanitize($v) {
		return htmlspecialchars(strip_tags($v));
	}
}

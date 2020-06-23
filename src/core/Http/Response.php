<?php

namespace Core\Http;

class Response {
	private $status;
	private $headers;

	public function __construct($status = 200, $headers = [], $stripHeaders = ['X-Powered-By']) {
		$this->status = $status;
		$this->headers = $headers;
		$this->stripHeaders = $stripHeaders;
	}

	public function respond($buffer) {
		$buffer = $this->processBuffer($buffer);

		isJson($buffer) ? $this->setJson() : $this->setHtml();
		$this->applyStatus()->applyHeaders();

		return $buffer;
	}

	public function redirect($url, $data=[]) {
		return $this->withStatus(303)
					->withHeader('Location', $url)
					->withData($data)
					->applyStatus()
					->applyHeaders();
	}

	private function processBuffer($buffer) {
		if (is_object($buffer) && method_exists($buffer, 'toJson')) {
			return $buffer->toJson();
		}

		if (is_array($buffer)) {
			if (is_object($buffer[0]) && method_exists($buffer[0], 'toArray')) {
				$buffer = array_map(function($b) { return $b->toArray(); }, $buffer);
			}
			return json_encode((array) $buffer);
		}

		return (string) $buffer;
	}

	public function withStatus($statusCode) {
		$this->status = $statusCode;
		return $this;
	}

	public function withHeader($header, $value) {
		$this->headers[$header] = $value;
		return $this;
	}

	public function withData($data) {
		foreach($data as $key => $value) {
			$_SESSION[$key] = $value;
		}
		return $this;
	}

	public function setJson() {
		return $this->withHeader('Content-Type', 'application/json; charset=utf-8');
	}

	public function setHtml() {
		return $this->withHeader('Content-Type', 'text/html; charset=utf-8');
	}

	private function applyStatus() {
		http_response_code($this->status);
		return $this;
	}

	private function applyHeaders() {
		foreach ($this->headers as $key => $value) {
			header(sprintf('%s: %s', $key, $value));
		}
		return $this->stripHeaders();
	}

	private function stripHeaders() {
		foreach($this->stripHeaders as $s) {
			header_remove($s);
		}
	}
}

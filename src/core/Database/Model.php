<?php

namespace Core\Database;

abstract class Model {
	protected $data;
	protected $query;

	public function __construct($data = null) {
		$this->data = (object) $data;
		$this->query = (new QueryBuilder)->select(implode(', ', $this->fields))->from($this->table);
	}

	public function __get($key) {
		if (property_exists($this->data, $key)) {
			return $this->data->{$key};
		}

		if (method_exists($this, $key)) {
			return $this->{$key}();
		}

		return null;
	}

	public function __call($method, $args) {
		if (in_array($method, get_class_methods(QueryBuilder::class))) {
			$this->query->{$method}(...$args);
			return $this;
		}

		throw new \Exception('Method call "' . $method . '" not found on model "' . static::class . '"');
	}

	public function first() {
		$data = (new DB)->execute($this->query->limit(1)->toSql())->data;
		if (isset($data) && count($data) > 0) {
			return new static($data[0]);
		}
		return null;
	}

	public function get() {
		$group = [];
		$values = (new DB)->execute($this->query->toSql())->data;

		foreach ($values as $d) {
			$group[] = new static($d);
		}

		return $group;
	}

	public function toArray() {
		return (array) $this->data;
	}

	public function toJson() {
		return json_encode($this->toArray());
	}
}

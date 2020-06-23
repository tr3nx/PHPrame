<?php

namespace Core\Database;

class QueryBuilder {
	private $table;
	private $fields = [];
	private $wheres = [];
	private $orderby;
	private $sort = 'DESC';
	private $limit = 0;
	private $offset = 0;

	public function select($fields) {
		$this->fields = $fields;
		return $this;
	}

	public function from($table) {
		$this->table = $table;
		return $this;
	}

	public function where($field, $value, $op = '=') {
		$this->wheres[] = [$field, $value, $op];
		return $this;
	}

	public function orderby($field) {
		$this->orderby = $field;
		return $this;
	}

	public function sort($direction = 'DESC') {
		$this->sort = (strtoupper($direction) == 'DESC' ? 'DESC' : 'ASC');
		return $this;
	}

	public function offset(int $amount = 0) {
		$this->offset = $amount;
		return $this;
	}

	public function limit(int $amount = 1) {
		$this->limit = $amount;
		return $this;
	}

	public function toSql() {
		$sql = "SELECT {$this->fields} FROM {$this->table}";

		if (count($this->wheres)) {
			$wheres = ' WHERE';
			foreach ($this->wheres as [$field, $value, $op]) {
				$wheres .= " {$field} {$op} {$value} AND";
			}
			$sql .= substr($wheres, 0, -4);
		}

		if (isset($this->orderby)) {
			$sql .= " ORDER BY {$this->orderby} {$this->sort}";
		}

		if ($this->limit > 0) {
			$sql .= " LIMIT {$this->limit}";
		}

		if ($this->offset > 0) {
			$sql .= " OFFSET {$this->offset}";
		}

		return $sql;
	}
}

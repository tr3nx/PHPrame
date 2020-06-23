<?php

namespace Core\Database;

class DB {
	public function connect($dsn, $persistent = false) {
		$persistent ? pg_pconnect($dsn) : pg_connect($dsn);
		return (bool) $this->isConnected();
	}

	public function disconnect() {
		return pg_close();
	}

	public function flush() {
		return pg_flush();
	}

	public function status() {
		return pg_connection_status();
	}

	public function isBusy() {
		return pg_connection_busy();
	}

	public function isConnected() {
		return pg_ping();
	}

	public function execute($query) {
		$result = pg_query($query);

		if ( ! $result) {
			return pg_last_error();
		}

		$data = [];
		$rows = pg_num_rows($result);
		while ($rows > 0 && $row = pg_fetch_assoc($result)) {
			$data[] = $row;
		}

		return (object) [
			'data' => $data,
			'raw' => $result,
			'status' => pg_result_status($result),
			'counts' => [
				'rows' => $rows,
				'fields' => pg_num_fields($result),
				'affected' => pg_affected_rows($result)
			]
		];
	}
}

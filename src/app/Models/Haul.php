<?php

namespace App\Models;

use Core\Database\Model;

class Haul extends Model {
	protected $table = 'hauls';
	protected $fields = ['id', 'caption', 'filename', 'fileext'];

	public function fullFilename() {
		return $this->data->filename . '.' . $this->data->fileext;
	}

	public function notDeleted() {
		$this->query->where('deleted_at', 'NULL', 'IS');
		return $this;
	}
}

<?php

namespace App\Controllers;

use App\Models\Haul;

class Home {
	public function index() {
		return [
			'title' => 'This is the title',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
		];
	}

	public function select($request) {
		$haul = (new Haul)->where('id', (int)sanitize($request->get('id')), '<');
		$haul = $haul->notDeleted();
		dd($haul);
		return $haul;
	}

	public function name($request) {
		return $request->get('name');
	}

	public function myname($request) {
		return 'my name: ' . $request->get('name');
	}

	public function form() {
		return '<form action="/submit" method="post"><input type="text" name="name"><button>send</button></form>';
	}

	public function thankyou($request) {
		return 'thank you, ' . $request->session('name') . '!';
	}

	public function submit($request, $response) {
		return $response->redirect('/thankyou', ['name' => $request->post('name')]);
	}

	public function fourohfour($request, $response) {
		$response->withStatus(404);
		return 'error 404';
	}
}

<?php

include_once CONTROLLERS_DIR . '/BaseController.php';

class HomeController extends BaseController
{
	protected function renderJSON(): string
	{
		return json([]);
	}

	protected function getRenderData(): array
	{
		include_once MODELS_DIR . '/UserModel.php';
		$test = new UserModel('logintest', 'passtest');
		$test->create();

		return [
			'welcomeMessage' => 'This is a welcome message from <code>HomeController.php</code>'
		];
	}
}

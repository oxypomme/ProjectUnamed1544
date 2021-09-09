<?php

include_once CONTROLLERS_DIR . '/BaseController.php';

class HomeController extends BaseController
{
	protected function renderJSON(): string
	{
		return json([]);
	}
}

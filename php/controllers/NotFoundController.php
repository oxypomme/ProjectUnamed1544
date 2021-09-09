<?php

include_once CONTROLLERS_DIR . '/BaseController.php';

class NotFoundController extends BaseController
{
	protected function renderJSON(): string
	{
		return json([
			'message' => "Error: ${_SERVER['PATH_INFO']} doesn't exist."
		], 404);
	}
}

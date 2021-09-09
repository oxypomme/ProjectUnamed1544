<?php

include_once CONTROLLERS_DIR . '/BaseController.php';

class PageController extends BaseController
{
	protected function renderJSON(): string
	{
		return json('{}');
	}
}

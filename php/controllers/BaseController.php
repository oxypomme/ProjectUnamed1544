<?php

include_once MODELS_DIR . '/ERenderType.php';

abstract class BaseController
{
	protected abstract function renderJSON(): string;

	public function render(int $renderType = ERenderType::STANDALONE)
	{
		$viewPath = str_replace('Controller', 'View', get_class($this));

		switch ($renderType) {
			case ERenderType::HTML:
				// Returning only the content
				include_once VIEWS_DIR . "/${viewPath}.php";
				break;

			case ERenderType::JSON:
				$this->renderJSON();
				break;

			default:
				// Returning the whole page
				include_once VIEWS_DIR . '/common/template.php';
				break;
		}
	}
}

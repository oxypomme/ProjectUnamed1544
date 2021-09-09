<?php

include_once MODELS_DIR . '/ERenderType.php';

abstract class BaseController
{
	/**
	 * Render fetched data to JSON.
	 * Used when called by the API
	 */
	protected abstract function renderJSON(): string;

	/**
	 * Render view linked to the Controller
	 *
	 * @param ERenderType The render format wanted
	 */
	public function render(int $renderType = ERenderType::STANDALONE): void
	{
		$viewPath = str_replace('Controller', 'View', get_class($this));

		switch ($renderType) {
			case ERenderType::HTML:
				// Returning only the content
				include_once VIEWS_DIR . "/${viewPath}.php";
				break;

			case ERenderType::JSON:
				echo $this->renderJSON();
				break;

			default:
				// Returning the whole page
				include_once VIEWS_DIR . '/common/template.php';
				break;
		}
	}
}

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
	 * Return data passed to the template and the content.
	 */
	protected abstract function getRenderData(): array;

	/**
	 * Render view linked to the Controller
	 *
	 * @param ERenderType $renderType The render format wanted
	 */
	public function render(int $renderType = ERenderType::STANDALONE): void
	{
		$viewPath = str_replace('Controller', 'View', get_class($this));
		$renderData = $this->getRenderData();

		switch ($renderType) {
			case ERenderType::HTML:
				// Returning only the content
				include_once VIEWS_DIR . "/${viewPath}.php";
				break;

			case ERenderType::JSON:
				// Returning only the JSON data
				header('Content-Type: application/json');
				echo $this->renderJSON();
				break;

			default:
				// Returning the whole page
				include_once VIEWS_DIR . '/common/template.php';
				break;
		}
	}
}

<?php

namespace Apitte\Debug\Tracy\BlueScreen;

use Apitte\Core\Exception\Logical\InvalidSchemaException;
use ReflectionClass;
use Tracy\BlueScreen;
use Tracy\Helpers;

final class ValidationBlueScreen
{

	/**
	 * @param BlueScreen $blueScreen
	 * @return void
	 */
	public static function register(BlueScreen $blueScreen)
	{
		$blueScreen->addPanel(function ($e) {
			if (!($e instanceof InvalidSchemaException)) return;

			return [
				'tab' => self::renderTab($e),
				'panel' => self::renderPanel($e),
			];
		});
	}

	/**
	 * @param InvalidSchemaException $e
	 * @return string
	 */
	private static function renderTab(InvalidSchemaException $e)
	{
		return 'Apitte - Validation';
	}

	/**
	 * @param InvalidSchemaException $e
	 * @return mixed
	 */
	private static function renderPanel(InvalidSchemaException $e)
	{
		if (!$e->controller || !$e->method) return NULL;

		$rf = new ReflectionClass($e->controller->getClass());
		$rm = $rf->getMethod($e->method->getName());

		return '<p><b>File:</b>' . Helpers::editorLink($rf->getFileName(), $rm->getStartLine()) . '</p>'
			. BlueScreen::highlightFile($rf->getFileName(), $rm->getStartLine(), 20);
	}

}

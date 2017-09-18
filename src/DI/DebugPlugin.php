<?php

namespace Apitte\Debug\DI;

use Apitte\Core\DI\AbstractPlugin;
use Apitte\Debug\Tracy\BlueScreen\ApiBlueScreen;
use Apitte\Debug\Tracy\Panel\ApiPanel;
use Nette\DI\CompilerExtension;
use Nette\DI\ContainerBuilder;
use Nette\PhpGenerator\ClassType;

class DebugPlugin extends AbstractPlugin
{

	const PLUGIN_NAME = 'debug';

	/**
	 * @param CompilerExtension $extension
	 */
	public function __construct(CompilerExtension $extension)
	{
		parent::__construct($extension);
		$this->name = self::PLUGIN_NAME;
	}

	/**
	 * Register services
	 *
	 * @return void
	 */
	public function loadPluginConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getExtensionConfig();

		if ($config['debug'] === TRUE) {
			$builder->addDefinition($this->prefix('panel'))
				->setClass(ApiPanel::class);
		}
	}

	/**
	 * @param ClassType $class
	 * @return void
	 */
	public function afterPluginCompile(ClassType $class)
	{
		$config = $this->getExtensionConfig();
		$initialize = $class->getMethod('initialize');

		if ($config['debug'] === TRUE) {
			$initialize->addBody('$this->getService(?)->addPanel($this->getByType(?));', ['tracy.bar', ApiPanel::class]);
		}

		$initialize->addBody('?::register($this->getService(?));', [ContainerBuilder::literal(ApiBlueScreen::class), 'tracy.blueScreen']);
	}

}

<?php

namespace Apitte\Debug\DI;

use Apitte\Core\DI\ApiExtension;
use Apitte\Core\DI\Plugin\AbstractPlugin;
use Apitte\Core\DI\Plugin\PluginCompiler;
use Apitte\Debug\Negotiation\Transformer\DebugDataTransformer;
use Apitte\Debug\Negotiation\Transformer\DebugTransformer;
use Apitte\Debug\Tracy\BlueScreen\ApiBlueScreen;
use Apitte\Debug\Tracy\Panel\ApiPanel;
use Nette\DI\ContainerBuilder;
use Nette\PhpGenerator\ClassType;

class DebugPlugin extends AbstractPlugin
{

	const PLUGIN_NAME = 'debug';

	/**
	 * @param PluginCompiler $compiler
	 */
	public function __construct(PluginCompiler $compiler)
	{
		parent::__construct($compiler);
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
		$config = $this->compiler->getExtension()->getConfig();

		if ($config['debug'] === TRUE) {
			$builder->addDefinition($this->prefix('panel'))
				->setClass(ApiPanel::class);

			$builder->addDefinition($this->prefix('transformer.debug'))
				->setFactory(DebugTransformer::class)
				->addTag(ApiExtension::NEGOTIATION_TRANSFORMER_TAG, ['suffix' => 'debug']);

			$builder->addDefinition($this->prefix('transformer.debugdata'))
				->setFactory(DebugDataTransformer::class)
				->addTag(ApiExtension::NEGOTIATION_TRANSFORMER_TAG, ['suffix' => 'debugdata']);
		}
	}

	/**
	 * @param ClassType $class
	 * @return void
	 */
	public function afterPluginCompile(ClassType $class)
	{
		$config = $this->compiler->getExtension()->getConfig();
		$initialize = $class->getMethod('initialize');

		if ($config['debug'] === TRUE) {
			$initialize->addBody('$this->getService(?)->addPanel($this->getByType(?));', ['tracy.bar', ApiPanel::class]);
		}

		$initialize->addBody('?::register($this->getService(?));', [ContainerBuilder::literal(ApiBlueScreen::class), 'tracy.blueScreen']);
	}

}

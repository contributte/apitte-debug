<?php

namespace Apitte\Debug\DI;

use Apitte\Core\DI\ApiExtension;
use Apitte\Core\DI\Plugin\AbstractPlugin;
use Apitte\Core\DI\Plugin\CoreSchemaPlugin;
use Apitte\Core\DI\Plugin\PluginCompiler;
use Apitte\Debug\Negotiation\Transformer\DebugDataTransformer;
use Apitte\Debug\Negotiation\Transformer\DebugTransformer;
use Apitte\Debug\Schema\Serialization\DebugSchemaDecorator;
use Apitte\Debug\Tracy\BlueScreen\ApiBlueScreen;
use Apitte\Debug\Tracy\Panel\ApiPanel;
use Apitte\Negotiation\DI\NegotiationPlugin;
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

		if ($config['debug'] !== TRUE) return;

		$builder->addDefinition($this->prefix('panel'))
			->setClass(ApiPanel::class);

		$this->loadNegotiationDebugConfiguration();
	}

	/**
	 * @return void
	 */
	protected function loadNegotiationDebugConfiguration()
	{
		// Skip if plugin apitte/negotiation is not loaded
		if (!$this->compiler->getPluginByType(NegotiationPlugin::class)) return;

		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('transformer.debug'))
			->setFactory(DebugTransformer::class)
			->addTag(ApiExtension::NEGOTIATION_TRANSFORMER_TAG, ['suffix' => 'debug']);

		$builder->addDefinition($this->prefix('transformer.debugdata'))
			->setFactory(DebugDataTransformer::class)
			->addTag(ApiExtension::NEGOTIATION_TRANSFORMER_TAG, ['suffix' => 'debugdata']);

		// Setup debug schema decorator
		CoreSchemaPlugin::$decorators['debug'] = new DebugSchemaDecorator();
	}

	/**
	 * @param ClassType $class
	 * @return void
	 */
	public function afterPluginCompile(ClassType $class)
	{
		$config = $this->compiler->getExtension()->getConfig();
		$initialize = $class->getMethod('initialize');

		$initialize->addBody('?::register($this->getService(?));', [ContainerBuilder::literal(ApiBlueScreen::class), 'tracy.blueScreen']);

		if ($config['debug'] === TRUE) {
			$initialize->addBody('$this->getService(?)->addPanel($this->getByType(?));', ['tracy.bar', ApiPanel::class]);
		}
	}

}

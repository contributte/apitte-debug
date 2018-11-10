<?php declare(strict_types = 1);

namespace Apitte\Debug\DI;

use Apitte\Core\DI\ApiExtension;
use Apitte\Core\DI\Plugin\AbstractPlugin;
use Apitte\Core\DI\Plugin\CoreSchemaPlugin;
use Apitte\Core\DI\Plugin\PluginCompiler;
use Apitte\Debug\Negotiation\Transformer\DebugDataTransformer;
use Apitte\Debug\Negotiation\Transformer\DebugTransformer;
use Apitte\Debug\Schema\Serialization\DebugSchemaDecorator;
use Apitte\Debug\Tracy\BlueScreen\ApiBlueScreen;
use Apitte\Debug\Tracy\BlueScreen\ValidationBlueScreen;
use Apitte\Debug\Tracy\Panel\ApiPanel;
use Apitte\Negotiation\DI\NegotiationPlugin;
use Nette\DI\ContainerBuilder;
use Nette\PhpGenerator\ClassType;
use Tracy\Debugger;

class DebugPlugin extends AbstractPlugin
{

	public const PLUGIN_NAME = 'debug';

	/** @var mixed[] */
	protected $defaults = [
		'debug' => true,
	];

	public function __construct(PluginCompiler $compiler)
	{
		parent::__construct($compiler);
		$this->name = self::PLUGIN_NAME;
	}

	/**
	 * Register services
	 */
	public function loadPluginConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$global = $this->compiler->getExtension()->getConfig();
		$config = $this->getConfig();

		if ($global['debug'] !== true && $config['debug'] !== true) return;

		$builder->addDefinition($this->prefix('panel'))
			->setFactory(ApiPanel::class);

		$this->loadNegotiationDebugConfiguration();

		// BueScreen - runtime
		ApiBlueScreen::register(Debugger::getBlueScreen());
		ValidationBlueScreen::register(Debugger::getBlueScreen());
	}

	protected function loadNegotiationDebugConfiguration(): void
	{
		// Skip if plugin apitte/negotiation is not loaded
		if ($this->compiler->getPluginByType(NegotiationPlugin::class) === null) return;

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

	public function afterPluginCompile(ClassType $class): void
	{
		$global = $this->compiler->getExtension()->getConfig();
		$config = $this->getConfig();

		$initialize = $class->getMethod('initialize');

		$initialize->addBody('?::register($this->getService(?));', [ContainerBuilder::literal(ApiBlueScreen::class), 'tracy.blueScreen']);
		$initialize->addBody('?::register($this->getService(?));', [ContainerBuilder::literal(ValidationBlueScreen::class), 'tracy.blueScreen']);

		if ($global['debug'] === true && $config['debug'] === true) {
			$initialize->addBody('$this->getService(?)->addPanel($this->getByType(?));', ['tracy.bar', ApiPanel::class]);
		}
	}

}

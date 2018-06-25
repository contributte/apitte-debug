<?php declare(strict_types = 1);

namespace Apitte\Debug\Schema\Serialization;

use Apitte\Core\Schema\Builder\SchemaBuilder;
use Apitte\Core\Schema\Serialization\IDecorator;

final class DebugSchemaDecorator implements IDecorator
{

	public function decorate(SchemaBuilder $builder): SchemaBuilder
	{
		foreach ($builder->getControllers() as $controller) {
			foreach ($controller->getMethods() as $method) {
				$negotiation1 = $method->addNegotiation();
				$negotiation1->setSuffix('.debugdata');

				$negotiation2 = $method->addNegotiation();
				$negotiation2->setSuffix('.debug');
			}
		}

		return $builder;
	}

}

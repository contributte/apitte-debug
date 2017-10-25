<?php

namespace Apitte\Debug\Schema\Serialization;

use Apitte\Core\Schema\Builder\SchemaBuilder;
use Apitte\Core\Schema\EndpointNegotiation;
use Apitte\Core\Schema\Serialization\IDecorator;

final class DebugSchemaDecorator implements IDecorator
{

	/**
	 * @param SchemaBuilder $builder
	 * @return SchemaBuilder
	 */
	public function decorate(SchemaBuilder $builder)
	{
		foreach ($builder->getControllers() as $controller) {
			foreach ($controller->getMethods() as $method) {
				$negotiation1 = $method->addNegotiation();
				$negotiation1->setType(EndpointNegotiation::TYPE_SUFFIX);
				$negotiation1->setMetadata(['suffix' => '.debugdata']);

				$negotiation2 = $method->addNegotiation();
				$negotiation2->setType(EndpointNegotiation::TYPE_SUFFIX);
				$negotiation2->setMetadata(['suffix' => '.debug']);
			}
		}

		return $builder;
	}

}

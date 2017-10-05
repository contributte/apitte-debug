<?php

/**
 * Test: Negotiation/Transformer/DebugDataTransformer
 */

use Apitte\Debug\Negotiation\Transformer\DebugDataTransformer;
use Apitte\Negotiation\Http\ArrayEntity;
use Contributte\Psr7\Psr7ResponseFactory;
use Ninjify\Nunjuck\Toolkit;
use Tester\Assert;
use Tracy\Debugger;

require_once __DIR__ . '/../../../bootstrap.php';

// Warnings
Toolkit::test(function () {
	$transformer = new DebugDataTransformer();

	$response = Psr7ResponseFactory::fromGlobal();
	$response = $response->withBody(ArrayEntity::from($response)->with(['foo' => 'bar']));
	$response = $transformer->encode($response);

	$response->getBody()->rewind();
	Assert::equal(Debugger::dump(['foo' => 'bar'], TRUE), $response->getBody()->getContents());
});

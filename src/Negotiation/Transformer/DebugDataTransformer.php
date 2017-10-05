<?php

namespace Apitte\Debug\Negotiation\Transformer;

use Apitte\Mapping\Http\ApiResponse;
use Apitte\Negotiation\Http\ArrayEntity;
use Apitte\Negotiation\Transformer\AbstractTransformer;
use Tracy\Debugger;
use function GuzzleHttp\Psr7\stream_for;

class DebugDataTransformer extends AbstractTransformer
{

	/** @var int */
	private $maxDepth;

	/** @var int */
	private $maxLength;

	/**
	 * @param int $maxDepth
	 * @param int $maxLength
	 */
	public function __construct($maxDepth = 10, $maxLength = 1500)
	{
		$this->maxDepth = $maxDepth;
		$this->maxLength = $maxLength;
	}

	/**
	 * @param ApiResponse $response
	 * @param array $options
	 * @return ApiResponse
	 */
	public function encode(ApiResponse $response, array $options = [])
	{
		if (!$this->acceptResponse($response)) return $response;

		Debugger::$maxDepth = $this->maxDepth;
		Debugger::$maxLength = $this->maxLength;

		$tmp = clone $response;

		$response = $response->withHeader('Content-Type', 'text/html')
			->withBody(stream_for());

		$response->getBody()->write(Debugger::dump($tmp->getEntity(), TRUE));

		return $response;
	}

}

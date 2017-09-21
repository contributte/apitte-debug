<?php

namespace Apitte\Debug\Negotiation\Transformer;

use Apitte\Negotiation\Http\ArrayStream;
use Apitte\Negotiation\Transformer\AbstractTransformer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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
	 * @param ResponseInterface $response
	 * @param array $options
	 * @return ResponseInterface
	 */
	public function encode(ResponseInterface $response, array $options = [])
	{
		if (!$this->acceptResponse($response)) return $response;

		Debugger::$maxDepth = $this->maxDepth;
		Debugger::$maxLength = $this->maxLength;

		$tmp = clone $response;
		/** @var ArrayStream $body */
		$body = $tmp->getBody();

		$response = $response->withHeader('Content-Type', 'text/html')
			->withBody(stream_for());

		$response->getBody()->write(Debugger::dump($body->getData(), TRUE));

		return $response;
	}

	/**
	 * @param ServerRequestInterface $request
	 * @param array $options
	 * @return null
	 */
	public function decode(ServerRequestInterface $request, array $options = [])
	{
		return NULL;
	}

}

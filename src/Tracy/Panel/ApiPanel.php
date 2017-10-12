<?php

namespace Apitte\Debug\Tracy\Panel;

use Apitte\Core\Schema\Schema;
use Tracy\IBarPanel;

final class ApiPanel implements IBarPanel
{

	/** @var Schema */
	private $schema;

	/**
	 * @param Schema $schema
	 */
	public function __construct(Schema $schema)
	{
		$this->schema = $schema;
	}

	/**
	 * Renders HTML code for custom tab.
	 *
	 * @return string
	 */
	public function getTab()
	{
		ob_start();
		$schema = $this->schema;
		require __DIR__ . '/templates/tab.phtml';

		return ob_get_clean();
	}

	/**
	 * Renders HTML code for custom panel.
	 *
	 * @return string
	 */
	public function getPanel()
	{
		ob_start();
		$schema = $this->schema;
		require __DIR__ . '/templates/panel.phtml';

		return ob_get_clean();
	}

}

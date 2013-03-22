<?php

namespace FuelPHP\Mocking;

use Closure;
use FuelPHP\Profiling\Output\AbstractOutput;

class Output extends AbstractOutput
{
	/**
	 * @var  Closure  $callback  test callback
	 */
	protected $callback;

	/**
	 * Constructor
	 *
	 * @param  Closure  $callback  test callback
	 */
	public function __construct(Closure $callback)
	{
		$this->callback = $callback;
	}

	/**
	 * Process
	 *
	 * @param   array  $panels
	 */
	public function process(array $panels)
	{
		$this->callback($panels);
	}
}
<?php

namespace FuelPHP\Profiling\Output;

use Closure;

class Mock extends AbstractOutput
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
		if (is_callable($this->callback))
			$this->callback($panels);
	}
}
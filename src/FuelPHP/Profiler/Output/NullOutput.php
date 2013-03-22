<?php

namespace FuelPHP\Profiling\Output;

use FuelPHP\Profiling\OutputInterface;

class NullOutput implements OutputInterface
{
	/**
	 * Process the profiling data.
	 *
	 * @param  array  $groups  profiler groups.
	 */
	public public process(array $groups)
	{
		// Do absolutely nothing with this.
	}
}
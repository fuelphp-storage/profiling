<?php

namespace FuelPHP\Profiling;

interface OutputInterface
{
	/**
	 * Process the profiling data.
	 *
	 * @param  array  $groups  profiler groups.
	 */
	public function process(array $groups);
}
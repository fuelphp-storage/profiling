<?php

namespace FuelPHP\Profiling\Output;

use FuelPHP\Profiling\OutputInterface;

abstract class AbstractOutput implements OutputInterface
{
	/**
	 * Normalize the context
	 *
	 * @param   array  $context  context
	 * @return  array  context
	 */
	public function normalizeContext(array $context)
	{
		if (isset($context['exception']))
		{
			$context['exception'] = $context['exception']->getMessage();
		}

		return $context;
	}
}
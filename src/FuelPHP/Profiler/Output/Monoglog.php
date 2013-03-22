<?php

namespace FuelPHP\Profiling\Output;

use Monolog\Logger;
use FuelPHP\Profiling\Entry;
use FuelPHP\Profiling\Panel;
use FuelPHP\Profiling\OutputInterface;

class Monolog implements OutputInterface
{
	protected $logLevel;

	/**
	 * Construct
	 *
	 * @param  Monolog\Logger  $logger  monolog instance
	 * @param  string          $level   log level
	 */
	public function __construct(Logger $logger, $logLevel = Logger::DEBUG)
	{
		$this->logger = $logger;
		$this->logLevel = $level;
	}

	/**
	 * Set the log level for Monolog
	 *
	 * @param   int|string  $level  log level
	 * @return  $this
	 */
	public function setLogLevel($level)
	{
		$this->level = $level;

		return $this;
	}

	/**
	 * Get the log level
	 *
	 * @return  int|string  log level
	 */
	public function getLogLevel()
	{
		return $this->logLevel;
	}

	/**
	 * Process the profiling data.
	 *
	 * @param  array  $panels  profiler panels.
	 */
	public function process(array $panels)
	{
		foreach ($panels as $panel)
		{
			$this->processPanel($panel);
		}
	}

	/**
	 * Process a Panel
	 *
	 * @param  FuelPHP\Profiling\Panel  $panel  panel
	 */
	public function processPanel(Panel $panel)
	{
		$message = 'Profiling panel: '.$panel->getName();
		$this->logger->log($this->level, $message, $panel->getProperties());

		foreach($panel->getEntries() as $entry)
		{
			$this->processEntry($entry)
		}
	}

	/**
	 * Process an Entry
	 *
	 * @param  FuelPHP\Profiling\Panel  $panel  panel
	 */
	public function processEntry(Entry $entry)
	{
		$level = $this->level;
		$context = $entry->getContext();

		if (isset($context['monolog_level']))
		{
			$level = $context['monolog_level'];
			unset($context['monolog_level']);
		}

		$this->logger->log($level, $entry->getMessage(), $context);
	}
}
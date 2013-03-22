<?php

namespace FuelPHP\Profiling;

class Panel
{
	/**
	 * @var  string  $name  name
	 */
	public $name;

	/**
	 * @var  array  $entries  panel entries
	 */
	protected $entries = array();

	/**
	 * @var  array  $properties  panel properties
	 */
	protected $properties = array();

	/**
	 * Constructor
	 *
	 * @param   string                     $name        panel name
	 * @param   FuelPHP\Profiling\Profiler  $profiler    profiler
	 * @param   array                      $properties  panel properties
	 */
	public function __construct($name, Profiler $profiler = null, array $properties = array())
	{
		$this->profiler = $profiler;
		$this->name = $name;
		$this->properties = $properties;
	}

	/**
	 * Get the panel name
	 *
	 * @return  string  panel name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set the panel properties
	 *
	 * @param   array  $properties  panel properties
	 * @param   bool   $merge       wether to merge with the existing properties
	 * @return  $this
	 */
	public function setProperties(array $properties, $merge = true)
	{
		if ( ! $merge)
		{
			$this->properties = $properties;

			return $this;
		}

		$this->properties = array_merge($this->properties, $properties);

		return $this;
	}

	public function getProperties()
	{
		return $this->properties;
	}

	public function setProfiler(Profiler $profiler)
	{
		$this->profiler = $profiler;

		return $this;
	}

	/**
	 * Finish an entry
	 *
	 * @param   FuelPHP\Profiling\Entry  $entry  profiling entry
	 * @return  $this
	 */
	public function finish(Entry $entry = null)
	{
		if ($entry)
			$entry->finish();

		return $this;
	}

	public function getFinishedEntries()
	{
		return array_filter($this->entries, function($entry)
		{
			return $entry->isFinished();
		});
	}

	public function getUnfinishedEntries()
	{
		return array_filter($this->entries, function($entry)
		{
			return $entry->isFinished();
		});
	}

	public function getEntries()
	{
		return $this->entries;
	}
}
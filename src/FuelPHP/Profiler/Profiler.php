<?php

namespace FuelPHP\Profiling;

use InvalidAgumentException;

class Profiler
{
	/**
	 * @var  array  $panels  profiler panels
	 */
	protected $panels = array();

	/**
	 * @var  array  $config  configuration
	 */
	protected $config = array(
		'timezone' => null,
		'output'   => array(),
		'enabled'  => true,
	);

	/**
	 * @var  array  $output  output interfaces
	 */
	protected $output = array();

	/**
	 * Constructor
	 *
	 * @param  array  $config  configuration options array
	 */
	public function __construct(array $config = array())
	{
		$this->configure($config);
	}

	/**
	 * Configure the profiler
	 *
	 * @param   array  $config  configuration
	 * @return  $this
	 */
	public function configure(array $config)
	{
		$newOutput = isset($config['output']);

		if ($newOutput and ! empty($this->output))
		{
			$this->output = array();
		}

		$this->config = array_merge($this->config, $config);

		foreach ((array) $this->config['output'] as $output)
		{
			$this->registerOutput($output);
		}

		return $this;
	}

	/**
	 * Register an output interface
	 *
	 * @param   FuelPHP\Profiling\OutputInterface|string  object or classname
	 * @return  $this
	 */
	public function registerOutput($output)
	{
		// Check for output resolving
		if (is_string($output))
		{
			$output = $this->resolveOutput($output);
		}

		if ( ! $output instanceof OutputInterface)
		{
			throw new InvalidAgumentException('Argument 1 of '.__FUNCTION__.' must be an instance of FuelPHP\Profiling\OutputInterface');
		}

		$outputClass = get_class($output);
		$this->output[$outputClass] = $output;

		return $this;
	}

	/**
	 * Enable the profiler
	 *
	 * @return  $this
	 */
	public function enable()
	{
		$this->config['enabled'] = true;

		return $this;
	}

	/**
	 * Disable the profiler
	 *
	 * @return  $this
	 */
	public function disable()
	{
		$this->config['enabled'] = false;

		return $this;
	}

	/**
	 * Check wether the profiler is enabled
	 *
	 * @return  bool  wether the profiler is enabled
	 */
	public function isEnabled()
	{
		return $this->config['enabled']
	}

	/**
	 * Create a new Output object based on a (class)name.
	 *
	 * @param   string  $output  output name or classname
	 */
	public function resolveOutput($output)
	{
		$input = $output;

		if ( ! class_exists($output, true))
		{
			$output = __NAMESPACE__.'\\'.ucfirst($output);
		}

		if ( ! class_exists($output, true))
		{
			throw new Exception('Could not resolve output: '.$input);
		}

		return new $output;
	}

	/**
	 * Starts profiling. Generates an entry in the given panel.
	 *
	 * @param   string  $panel  panel name
	 * @return  FuelPHP\Profiling\Entry
	 */
	public function start($panel, $message, array $context = array())
	{
		if ($this->enabled)
		{
			$panel = $this->getPanel($panel);

			return $panel->start($message, $context);
		}
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

	/**
	 * Get a profiling panel.
	 *
	 * @param   string  $panel  panel name
	 * @return  FuelPHP\Profiling\Panel
	 */
	public function getPanel($panel)
	{
		if ( ! isset($this->panels[$panel]))
		{
			$this->panels[$panel] = new Panel($panel, $this);
		}

		return $this->panels[$panel];
	}

	/**
	 * Inject a panel into the profiler
	 *
	 * @param   FuelPHP\Profiling\panel  profiler panel
	 * @return  $this
	 */
	public function setPanel(Panel $panel)
	{
		$panel->setProfiler($this);
		$this->panels[$panel->getName()] = $panel;

		return $this;
	}

	/**
	 * Ensure a panel
	 *
	 * @param   string  $panel       panel name
	 * @param   array   $properties  panel properties
	 * @return  $this
	 */
	public function ensurePane($panel, array $propeties = array())
	{
		$panel = $this->getPanel($panel);
		$panel->setProperties($propeties);

		return $this;
	}

	/**
	 * Offloads the profiler panels to all registered output interfaces.
	 *
	 * @return  void
	 */
	public function output()
	{
		if ( ! $this->config['enabled'])
		{
			return;
		}

		foreach ($this->output as $output)
		{
			$output->process($this->panels);
		}
	}
}
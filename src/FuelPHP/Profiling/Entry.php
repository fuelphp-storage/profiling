<?php

namespace FuelPHP\Profiling;

class Entry
{
	/**
	 * @var  int  $start  start time
	 */
	protected $start;

	/**
	 * @var  int  $end  end time
	 */
	protected $end;

	/**
	 * @var  int  $interval  interval
	 */
	protected $interval;

	/**
	 * @var  string  $message  profiling message
	 */
	protected $message;

	/**
	 * @var  array  $context  context
	 */
	protected $context = array();

	/**
	 * @var  bool  $finished  wether to entry is finished
	 */
	public $finished = false;

	/**
	 * Contructor
	 *
	 * @param   FuelPHP\Profiling\Panel  $panel    parent panel
	 * @param   string                  $message  message
	 * @param   array                   $context  context
	 */
	public function __construct(Panel $panel, $message, array $context = null)
	{
		$this->panel = $panel;
		$this->message = $message;

		if ($context)
			$this->setContext($context);

		$this->start = microtime();
	}

	/**
	 * Finish profiling an entry
	 *
	 * @return  $this
	 */
	public function finish()
	{
		$this->end = microtime();
		$this->interval = $this->end - $this->start;
		$this->finished = true;

		return $this;
	}

	/**
	 * Set context variables
	 *
	 * @param   array  $context  context
	 * @return  $this
	 */
	public function setContext(array $context)
	{
		$this->context = array_merge($this->context, $context);

		return $this;
	}

	/**
	 * Get context variables
	 *
	 * @return  $this
	 */
	public function getContext()
	{
		$context = $this->context;
		$context['start'] = $this->start;
		$context['end'] = $this->end;
		$context['interval'] = $this->interval;

		return $context;
	}

	public function isFinished()
	{
		return $this->finished;
	}
}
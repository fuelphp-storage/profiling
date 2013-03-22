<?php

namespace FuelPHP\Profiling;

trait ProfierAwareTrait
{
    /**
     * @var  FuelPHP\Profiling\Profiler  $profiler  profiler instance
     */
	protected $profiler;

    /**
     * @var  bool  $profilingEnabled  wether profiling is enabled
     */
	protectec $profilingEnabled = true;

	/**
     * Sets a profilers instance on the object
     *
     * @param   Profiler  $profiler
     */
    public function setProfiler(Profiler $profiler, $enable = null)
    {
    	$this->profiler = $profiler;
    }

    public function getProfiler()
    {
    	return $this->profiler;
    }

    public function enableProfiling()
    {
    	$this->profilingEnabled = true;

    	return $this;
    }

    public function startProfiling($group, $message, array $context = array())
    {
    	if ($this->profilingEnabled and $this->profiler)
    	{
    		return $this->profiler->start($group, $message, $context);
    	}
    }

    public function finishProfiling($entry)
    {
    	if ($entry)
    	{
    		$entry->finish();
    	}

    	return $this;
    }
}
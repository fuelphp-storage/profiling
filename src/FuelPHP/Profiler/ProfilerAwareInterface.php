<?php

namespace FuelPHP\Profiling;

interface ProfierAwareInterface
{
	/**
     * Sets a profilers instance on the object
     *
     * @param   Profiler  $profiler
     */
    public function setProfiler(Profiler $profiler);
}
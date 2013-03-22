# FuelPHP Profiling Package

```
// bootstrap
$profiler = new FuelPHP\Profiling\Profiler;
$profiler->registerOutput(new FuelPHP\Profiling\Output\Monolog($monolog));

// start profiling from the profiler.
$entry = $profiler->start('Panel Name', 'Entry Name');

// or get a panel
$panel = $profiler->getPanel('Other Panel Name');

// and create a new entry from the panel
$entry = $panel->start('Entry Mame');

// you can also provide context vars
$entry = $profiler->start('

// finish profiling the entry
$entry->finish();

// or send it to the to the panel
$panel->finish($entry);

// or to the profiler
$profiler->finish($entry);

// Last but not least, initiate the output processing
$profiler->output();

```
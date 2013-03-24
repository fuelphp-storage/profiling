# FuelPHP Profiling Package (2.0 WIP)

## Internals

The profiling package will have an easy to use interface for profiling
arbitraty data. The profiler is contrusted out of 3 main parts:

* __Profiler__<br/>The main container tying everything together
* __Panels__<br/>Groups of profiling data which contain contextual data for containing entries.
* __Entries__<br/>The actual profiling data.

### Profiler Class

The profiler's main concern is being active or disabled. It contains panels and output channels.

### Panel Class

A panel holds grouped entries. It has it's own properties which can aid output classes in displaying or formatting data.

### Entry Class

The autonomy of an entry consists out of 3 parts:

* The message
* Contextual data
* Start time
* End time (when finished)
* The interval (when finished)

## Output Interface

The output interface is responsible for formatting and presenting the profiler data. When processing the data it receives an array of panels which contain entries. The panels haven methods to distinguish finished and unfinished entries and should act on the accordingly (in whichever way is suitable to the channel type).

Because of it's uniform interface a lot of different output channels can be thought off:

* A webinterface
* Monolog logging
* Email's when the app is running slow
* or even a node.js socket which will output profiling data in an external window.



## Example Usage


```
// bootstrap
$profiler = new FuelPHP\Profiling\Profiler;
$profiler->registerOutput(new FuelPHP\Profiling\Output\Monolog($monolog));

// start profiling from the profiler.
$entry = $profiler->start('Panel Name', 'Entry Name');

// or get a panel
$panel = $profiler->getPanel('Other Panel Name');

// and create a new entry from the panel
$entry = $panel->start('Entry Name');

// you can also provide context vars
$entry = $panel->start('Entry Name', array(
	'name' => 'value',
));

// finish profiling the entry
$entry->finish();

// or send it to the to the panel
$panel->finish($entry);

// or to the profiler
$profiler->finish($entry);

// Last but not least, initiate the output processing
$profiler->output();
```


# History

This module will provide a browser-safe history for Kohana, so you don't have to rely on the referrer.

## Installation

Enable the module in your **bootstrap.php**:

	Kohana::modules(array(
		'history' => MODPATH.'history',
		// ...
	));

## Configuration

Set the desired history size in *MODPATH/history/classes/history/core.php*, using the `$size` variable.

## Usage

#### Saving the history

To save the current URL to the history use the `History::push()` method.

For example you can place this in your controller's `before()` method to automatically update the history.

It's possible to add a custom URL to the history by supplying it as parameter for the method: `History::push($url)`.

#### Retrieving the history

Use the `History::get()` method to return the whole history in an array.

#### Getting the last (previous) URL

To get the last URL, simply use the `History::last()` method.

#### Clearing history

To clear your history use the `History::clear()` method.




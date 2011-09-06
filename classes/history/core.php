<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Browser History
 *
 * @package     History
 * @author      creatoro, Vijay Mahrra, Sheikh Ahmed, Alex Sancho
 * @copyright   (c) 2011
 * @license     http://creativecommons.org/licenses/by-sa/3.0/legalcode
 */
class History_Core {

	/**
	 * @var  int  the number of URLs saved in history.
	 */
	public static $size = 2;

	/**
	 * Pushes the current or supplied URL to the history.
	 *
	 * @param   null|string  $current_url  the URL that goes into history
	 * @return  array
	 * @uses    Request::detect_uri
	 * @uses    Session::instance
	 */
    public static function push($current_url = NULL)
    {
		if ($current_url === NULL)
		{
			// Detect current URL
			$current_url = Request::detect_uri();

			if ($query = Request::current()->query())
			{
				// Add query to URL
				$current_url .= '?'.http_build_query($query);
			}
		}

		if ( ! $history = Session::instance()->get('url_history'))
		{
			// Create URL history in session
			$history = Session::instance()->set('url_history', array($current_url));
		}

		if (current($history) != $current_url)
		{
			// Add the current URL to history as it's a new URL
			array_unshift($history, $current_url);
		}

		if (self::$size > 0)
		{
            // Remove URLs from history that exceed the history size limit
			$history = Session::instance()->set('url_history', array_unique(array_slice($history, 0, self::$size)));
        }

		// Return history
		return $history;
    }

    /**
	 * Returns the full history.
	 *
	 * @static
	 * @return  array
	 * @uses    Session::instance
	 */
	public static function get()
    {
        return Session::instance()->get('url_history', array());
    }

    /**
	 * Returns the last URL from history.
	 *
	 * @static
	 * @return  bool|string
	 * @uses    Arr::get
	 * @uses    Session::instance
	 */
	public static function last()
    {
		// Set history
		 $history = Session::instance()->get('url_history', array());

		if ( ! $last = end($history))
		{
			// No last page is available
			return FALSE;
		}
		
        // Return the URL
        return $last;
    }

    /**
	 * Deletes the history.
	 *
	 * @static
	 * @return  void
	 * @uses    Session::instance
	 */
	public static function clear()
    {
		Session::instance()->delete('url_history');
    }

} // End History_Core
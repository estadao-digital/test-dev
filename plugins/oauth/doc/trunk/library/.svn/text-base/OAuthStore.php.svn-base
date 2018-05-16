<?php

/**
 * Storage container for the oauth credentials, both server and consumer side.
 * This is the factory to select the store you want to use
 * 
 * @version $Id$
 * @author Marc Worrell <marcw@pobox.com>
 * @date  Nov 16, 2007 4:03:30 PM
 * 
 * 
 * The MIT License
 * 
 * Copyright (c) 2007-2008 Mediamatic Lab
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

require_once dirname(__FILE__) . '/OAuthException2.php';

class OAuthStore
{
	static private $instance = false;

	/**
	 * Request an instance of the OAuthStore
	 * 
	 * @param string $store The storage system
	 * @param array $options To pass to the storage system
	 * @param boolean $forceNewInstance If true, forces the instantiation of a new store.
	 * @throws OAuthException2
	 */
	public static function instance ( $store = 'MySQL', $options = array(), $forceNewInstance = false )
	{
	    if (!OAuthStore::$instance or $forceNewInstance)
	    {
			// Select the store you want to use
			if (strpos($store, '/') === false)
			{
				$class = 'OAuthStore'.$store;
				$file  = dirname(__FILE__) . '/store/'.$class.'.php';
			}
			else
			{
				$file  = $store;
				$store = basename($file, '.php');
				$class = $store;
			}

			if (is_file($file))
			{
				require_once $file;
				
				if (class_exists($class))
				{
					OAuthStore::$instance = new $class($options);
				}
				else
				{
					throw new OAuthException2('Could not find class '.$class.' in file '.$file);
				}
			}
			else
			{
				throw new OAuthException2('No OAuthStore for '.$store.' (file '.$file.')');
			}
	    }
	    return OAuthStore::$instance;	
	}
}


/* vi:set ts=4 sts=4 sw=4 binary noeol: */

?>
<?php

/**
 * Nette Framework
 *
 * Copyright (c) 2004, 2009 David Grudl (http://davidgrudl.com)
 *
 * This source file is subject to the "Nette license" that is bundled
 * with this package in the file license.txt.
 *
 * For more information please see http://nettephp.com
 *
 * @copyright  Copyright (c) 2004, 2009 David Grudl
 * @license    http://nettephp.com/license  Nette license
 * @link       http://nettephp.com
 * @category   Nette
 * @package    Nette\Loaders
 * @version    $Id: SimpleLoader.php 182 2008-12-31 00:28:33Z david@grudl.com $
 */



require_once dirname(__FILE__) . '/../Loaders/AutoLoader.php';



/**
 * Auto loader is responsible for loading classes and interfaces.
 *
 * @author     David Grudl
 * @copyright  Copyright (c) 2004, 2009 David Grudl
 * @package    Nette\Loaders
 */
class SimpleLoader extends AutoLoader
{

	/**
	 * Handles autoloading of classes or interfaces.
	 * @param  string
	 * @return void
	 */
	public function tryLoad($type)
	{
		if (strpbrk($type, './;|') !== FALSE) {
			throw new InvalidArgumentException("Invalid class/interface name '$type'.");
		}

		$file = strtr($type, '\\', '/') . '.php';

		/*
		if (strncmp($type, 'Nette\\', 6) === 0) {
			$file = dirname(dirname(dirname(__FILE__))) . '/' . $file;
		}
		*/

		@LimitedScope::load($file);
		self::$count++;
	}

}

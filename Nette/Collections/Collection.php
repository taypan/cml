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
 * @package    Nette\Collections
 * @version    $Id: Collection.php 238 2009-03-27 13:21:11Z david@grudl.com $
 */



require_once dirname(__FILE__) . '/../Collections/ICollection.php';



/**
 * SPL ArrayObject customization.
 *
 * @author     David Grudl
 * @copyright  Copyright (c) 2004, 2009 David Grudl
 * @package    Nette\Collections
 */
abstract class Collection extends ArrayObject implements ICollection
{
	/** @var string  type (class, interface, PHP type) */
	protected $itemType;

	/** @var string  function to verify type */
	protected $checkFunc;

	/** @var bool */
	protected $readOnly = FALSE;



	/**
	 * @param  array to wrap
	 * @param  string class/interface name or ':type'
	 * @throws InvalidArgumentException
	 */
	public function __construct($arr = NULL, $type = NULL)
	{
		if (substr($type, 0, 1) === ':') {
			$this->itemType = substr($type, 1);
			$this->checkFunc = 'is_' . $this->itemType;
		} else {
			$this->itemType = $type;
		}

		if ($arr !== NULL) {
			$this->import($arr);
		}
	}



	/**
	 * Prevent any more modifications.
	 * @return void
	 */
	public function setReadOnly()
	{
		$this->readOnly = TRUE;
	}



	/**
	 * Appends the specified element to the end of this collection.
	 * @param  mixed
	 * @return void
	 * @throws InvalidArgumentException
	 */
	public function append($item)
	{
		$this->beforeAdd($item);
		parent::append($item);
	}



	/**
	 * Removes the first occurrence of the specified element.
	 * @param  mixed
	 * @return bool  true if this collection changed as a result of the call
	 * @throws NotSupportedException
	 */
	public function remove($item)
	{
		$this->beforeRemove();
		$index = $this->search($item);
		if ($index === FALSE) {
			return FALSE;
		} else {
			parent::offsetUnset($index);
			return TRUE;
		}
	}



	/**
	 * Returns the index of the first occurrence of the specified element,.
	 * or FALSE if this collection does not contain this element.
	 * @param  mixed
	 * @return int|FALSE
	 */
	protected function search($item)
	{
		return array_search($item, $this->getArrayCopy(), TRUE);
	}



	/**
	 * Removes all of the elements from this collection.
	 * @return void
	 * @throws NotSupportedException
	 */
	public function clear()
	{
		$this->beforeRemove();
		parent::exchangeArray(array());
	}



	/**
	 * Returns true if this collection contains the specified item.
	 * @param  mixed
	 * @return bool
	 */
	public function contains($item)
	{
		return $this->search($item) !== FALSE;
	}



	/**
	 * Import from array or any traversable object.
	 * @param  array|\Traversable
	 * @return void
	 * @throws InvalidArgumentException
	 */
	public function import($arr)
	{
		if (!(is_array($arr) || $arr instanceof Traversable)) {
			throw new InvalidArgumentException("Argument must be traversable.");
		}

		$this->clear();
		foreach ($arr as $item) {
			$this->offsetSet(NULL, $item);
		}
	}



	/**
	 * Returns a value indicating whether collection is read-only.
	 * @return bool
	 */
	public function isReadOnly()
	{
		return $this->readOnly;
	}



	/********************* internal notifications ****************d*g**/



	/**
	 * Responds when the item is about to be added to the collection.
	 * @param  mixed
	 * @return void
	 * @throws InvalidArgumentException, \NotSupportedException
	 */
	protected function beforeAdd($item)
	{
		if ($this->readOnly) {
			throw new NotSupportedException('Collection is read-only.');
		}

		if ($this->itemType !== NULL) {
			if ($this->checkFunc === NULL) {
				if (!($item instanceof $this->itemType)) {
					throw new InvalidArgumentException("Item must be '$this->itemType' object.");
				}
			} else {
				$fnc = $this->checkFunc;
				if (!$fnc($item)) {
					throw new InvalidArgumentException("Item must be $this->itemType type.");
				}
			}
		}
	}



	/**
	 * Responds when an item is about to be removed from the collection.
	 * @return void
	 * @throws NotSupportedException
	 */
	protected function beforeRemove()
	{
		if ($this->readOnly) {
			throw new NotSupportedException('Collection is read-only.');
		}
	}



	/********************* ArrayObject cooperation ****************d*g**/



	/**
	 * Returns the iterator.
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->getArrayCopy());
	}



	/**
	 * Not supported. Use import().
	 */
	public function exchangeArray($array)
	{
		throw new NotSupportedException('Use ' . __CLASS__ . '::import()');
	}



	/**
	 * Protected exchangeArray().
	 * @param  array  new array
	 * @return void
	 */
	protected function setArray($array)
	{
		parent::exchangeArray($array);
	}



	/********************* Nette\Object behaviour ****************d*g**/



	/**
	 * Returns the name of the class of this object.
	 *
	 * @return string
	 */
	final public function getClass()
	{
		return get_class($this);
	}



	/**
	 * Call to undefined method.
	 *
	 * @throws MemberAccessException
	 */
	public function __call($name, $args)
	{
		return ObjectMixin::call($this, $name, $args);
	}



	/**
	 * Call to undefined static method.
	 *
	 * @throws MemberAccessException
	 */
	public static function __callStatic($name, $args)
	{
		$class = get_called_class();
		throw new MemberAccessException("Call to undefined static method $class::$name().");
	}



	/**
	 * Returns property value. Do not call directly.
	 *
	 * @throws MemberAccessException if the property is not defined.
	 */
	public function &__get($name)
	{
		return ObjectMixin::get($this, $name);
	}



	/**
	 * Sets value of a property. Do not call directly.
	 *
	 * @throws MemberAccessException if the property is not defined or is read-only
	 */
	public function __set($name, $value)
	{
		return ObjectMixin::set($this, $name, $value);
	}



	/**
	 * Is property defined?
	 *
	 * @param  string  property name
	 * @return bool
	 */
	public function __isset($name)
	{
		return ObjectMixin::has($this, $name);
	}



	/**
	 * Access to undeclared property.
	 *
	 * @throws MemberAccessException
	 */
	public function __unset($name)
	{
		throw new MemberAccessException("Cannot unset the property $this->class::\$$name.");
	}

}

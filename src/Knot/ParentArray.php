<?php

namespace Knot;

use \Knot\Exceptions\WrongFunctionException;
use \Knot\Exceptions\WrongArrayPathException;

/**
 * Main Knot class.
 */
class ParentArray extends \Knot implements \Arrayaccess, \Countable {

	/**
	 * Knot data.
	 * @var array
	 */
	Protected $data;

	/**
	 * @var self
	 */
	Protected $parent_array;

	/**
	 * @var string
	 */
	Protected $path = '';

	/**
	 * @param array $data
	 * @param $father
	 * @param $path
	 */
	Public function __construct(array &$data, $father, $path)
	{
		$this->data =& $data;
		$this->path = $path;
		$this->parent_array = $father;
	}

	Public function __set($key, $value)
	{
		$this->data[$key] = $value;
	}

	/**
	 * @param string|int $key
	 * @return mixed|\Knot\ChildArray
	 * @throws \Exception
	 */
	Public function &__get($key)
	{
		if (array_key_exists($key, $this->data)) {
			$target =& $this->data[$key];
		} else {
			throw new WrongArrayPathException($key);
		}

		if (is_array($target)) {
			$r = new ChildArray($target, $this->childParent(), $this->path($key));
			return $r;
		}

		return $target;
	}

	/**
	 * @param $method
	 * @param $arguments
	 * @return mixed
	 * @throws \Exception
	 */
	Private function callDataFunction($method, $arguments)
	{
		if (!$this->keyExists($method) || !is_callable($f = $this->data[$method])) {
			throw new WrongFunctionException("Wrong function name!");
		}

		try {
			$arguments = array_merge(array(&$this->data), $arguments);
			return call_user_func_array($this->data[$method], $arguments);
		}
		catch(\Exception $e) {
			throw $e;
		}
	}

	/**
	 * @param $method
	 * @param $arguments
	 * @return mixed
	 * @throws \Exception
	 */
	Private function callHelperFunction($method, $arguments)
	{
		try{
			return \Knot::$helper_manager->execute($method, $arguments, $this);
		}
		catch(\Exception $e) {
			throw $e;
		}
	}

	/**
	 * Function list: Callable Data + Helper Libraries!
	 * @param string $method
	 * @param array $arguments
	 * @return $this|mixed
	 * @throws \Exception|WrongFunctionException
	 */
	Public function __call($method, $arguments = array())
	{

		// First try to call Data Function.
		try {
			return $this->callDataFunction($method, $arguments);
		}
		catch(WrongFunctionException $e) {}
		catch(\Exception $e) {
			throw $e;
		}

		// Try to call Helper function.
		try{
			return $this->callHelperFunction($method, $arguments);
		}
		catch(\Exception $e) {
			throw $e;
		}

	}

	/**
	 * @param mixed $key
	 * @return bool
	 */
	Public function __isset($key)
	{
		return isset($this->data[$key]);
	}

	/**
	 * @param mixed $key
	 */
	Public function __unset($key)
	{
		unset($this->data[$key]);
	}

	/**
	 * Easy Access for get function!
	 * @param $path
	 * @return mixed
	 */
	Public function __invoke($path)
	{
		return call_user_func_array(array($this, 'get'), func_get_args());
	}

	/**
	 * In ParentArray's child's parent is self.
	 * @return $this
	 */
	Public function childParent()
	{
		return $this;
	}

	/**
	 * Only search own data keys.
	 * @param mixed $key
	 * @return bool|false|true
	 */
	Public function keyExists($key)
	{
		return isset($this->data[$key]);
	}
	
	/**
	 * Reset data!
	 * @return $this
	 */
	Public function kill()
	{
		$this->data = array();
		return $this;
	}

	/**
	 * @param null $add
	 * @return null|string
	 */
	Public function path($add = null)
	{
		return $add ?
			$this->path != null ? $this->path . self::ARRAY_PATH_DELIMITER . $add :  $add
			:
			$this->path;
	}

	/**
	 * @param $path
	 * @return array
	 */
	Public static function pathParser($path)
	{
		return explode(self::ARRAY_PATH_DELIMITER, $path);
	}

	/**
	 * @param array $path
	 * @return string
	 */
	Public static function pathCombiner(array $path)
	{
		return implode(self::ARRAY_PATH_DELIMITER, $path);
	}

	/**
	 * @return int|string
	 */
	Public function lastKey()
	{
		end( $this->data );
		return key( $this->data );
	}

	/**
	 * @return array
	 */
	Public function &toArray()
	{
		return $this->data;
	}

	Public function copy()
	{
		$_data = $this->data;
		return new self($_data, null, '');
	}

	/* ===============================================
	 * ===============================================
	 * Array Access Interface.
	 *
	 * Array Access ile direk data içindeki değer döndürülür.
	 */

	/**
	* @param mixed $offset
	* @return boolean
	*/               
	Public function offsetExists( $offset )
	{
		return $this->__isset( $offset );
	}
	
	/**
	* @param mixed $offset
	* @return mixed
	*/
	Public function &offsetGet( $offset )
	{
		if ( is_null( $offset ) ) {
			$this->data[] = array();

			return $this->data[$this->lastKey()];
		}
		return $this->data[$offset];
	}

	/**
	* @param mixed $offset
	* @param mixed $value
	* @return void
	*/
	Public function offsetSet( $offset,  $value )
	{
		if ( is_null( $offset ) ) {
			$this->data[]= $value;
		} else {
			$this->data[$offset] = $value;
		}
	}
	
	/**
	 * @param mixed $offset
	 * @return void
	*/
	Public function offsetUnset( $offset )
	{
		$this->__unset($offset);
	}

	/* ===============================================
	 * ===============================================
	 * Countable Interface.
	 */

	/**
	 * @return int
	 */
	Public function count()
	{
		return count($this->data);
	}
}

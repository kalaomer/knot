<?php namespace Knot\Dict;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use ArrayIterator;

use Knot\Dict\IDEHelper;
use Knot\Exceptions\FunctionExecuteException;
use Knot\Exceptions\WrongFunctionException;
use Knot\Exceptions\WrongArrayPathException;

/**
 * Main Knot class.
 */
abstract class AbstractBody implements Arrayaccess, Countable, IteratorAggregate, IDEHelper {

	/**
	 * For parsing array path.
	 */
	const ARRAY_PATH_DELIMITER = ".";

	/**
	 * Knot data.
	 * @var array
	 */
	protected $data;

	/**
	 * @var self
	 */
	protected $parentArray;

	/**
	 * @var string
	 */
	protected $path = '';


	/**
	 * In ParentArray's child's parent is self.
	 * @return self
	 */
	abstract public function childParent();


	/**
	 * Reset data!
	 * @return $this
	 */
	abstract public function kill();


	/**
	 * @param array $data
	 * @param       $father
	 * @param       $path
	 */
	public function __construct(array &$data, $father, $path)
	{
		$this->data        =& $data;
		$this->path        = $path;
		$this->parentArray = $father;
	}


	public function __set($key, $value)
	{
		$this->data[$key] = $value;
	}


	/**
	 * @param string|int $key
	 *
	 * @return mixed|\Knot\Dict\ChildDict
	 * @throws \Exception
	 */
	public function &__get($key)
	{
		if ( array_key_exists($key, $this->data) )
		{
			$target =& $this->data[$key];
		}
		else
		{
			throw new WrongArrayPathException($key);
		}

		if ( is_array($target) )
		{
			$r = new ChildDict($target, $this->childParent(), $this->path($key));

			return $r;
		}

		return $target;
	}


	/**
	 * Call callable data variable.
	 *
	 * @param $method
	 * @param ...$arguments
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function call($method, $arguments)
	{
		$arguments = func_get_args();
		$method    = array_shift($arguments);

		$function = $this->data[$method];

		if ( ! $this->keyExists($method) || ! is_callable($function) )
		{
			throw new WrongFunctionException("Wrong function or not callable name!");
		}

		try
		{
			$arguments = array_merge([ &$this->data ], $arguments);

			return call_user_func_array($function, $arguments);
		}
		catch (\Exception $e)
		{
			throw new FunctionExecuteException($method);
		}
	}


	/**
	 * Function list: Helper Libraries!
	 *
	 * @param string $method
	 * @param array  $arguments
	 *
	 * @return $this|mixed
	 * @throws \Exception|WrongFunctionException
	 */
	public function __call($method, $arguments = [ ])
	{
		try
		{
			return $this->getHelperManager()->execute($method, $arguments, $this);
		}
		catch (\Exception $e)
		{
			throw $e;
		}
	}


	/**
	 * @param mixed $key
	 *
	 * @return bool
	 */
	public function __isset($key)
	{
		return isset( $this->data[$key] );
	}


	/**
	 * @param mixed $key
	 */
	public function __unset($key)
	{
		unset( $this->data[$key] );
	}


	/**
	 * Easy Access for get function!
	 *
	 * @param $path
	 *
	 * @return mixed
	 */
	public function __invoke($path)
	{
		return call_user_func_array([ $this, 'get' ], func_get_args());
	}


	/**
	 * Only search own data keys.
	 *
	 * @param mixed $key
	 *
	 * @return bool|false|true
	 */
	public function keyExists($key)
	{
		return isset( $this->data[$key] );
	}


	public function getHelperManager()
	{
		return HelperManager::getInstance();
	}


	/**
	 * @param null $add
	 *
	 * @return null|string
	 */
	public function path($add = null)
	{
		return $add ? $this->path != null ? $this->path . static::ARRAY_PATH_DELIMITER . $add : $add : $this->path;
	}


	/**
	 * @param $path
	 *
	 * @return array
	 */
	public static function pathParser($path)
	{
		return explode(self::ARRAY_PATH_DELIMITER, $path);
	}


	/**
	 * @param array $path
	 *
	 * @return string
	 */
	public static function pathCombiner(array $path)
	{
		return implode(self::ARRAY_PATH_DELIMITER, $path);
	}


	/**
	 * @return int|string
	 */
	public function lastKey()
	{
		end($this->data);

		return key($this->data);
	}


	/**
	 * @return array
	 */
	public function &toArray()
	{
		return $this->data;
	}


	public function copy()
	{
		$_data = $this->data;

		return new ParentDict($_data, null, '');
	}

	/* ===============================================
	 * ===============================================
	 * Path functions for Dict.
	 *
	 */

	/**
	 * @param $path
	 *
	 * @return bool
	 */
	public function isPath($path)
	{
		try
		{
			$this->get($path);

			return true;
		}
		catch (WrongArrayPathException $e)
		{
			return false;
		}
	}


	public function get($path)
	{
		$arguments = func_get_args();

		isset( $arguments[1] ) && $default_return = $arguments[1];

		$target_data =& $this->data;

		foreach (static::pathParser($path) as $way)
		{

			if ( ! isset( $target_data[$way] ) )
			{

				if ( isset( $default_return ) )
				{
					$r = $this->set($path, $default_return);

					return $r;
				}

				throw new WrongArrayPathException($path);
			}

			$target_data = &$target_data[$way];
		}

		if ( is_array($target_data) )
		{
			return new ChildDict($target_data, $this->childParent(), $path);
		}

		return $target_data;
	}


	/**
	 * For Get path without parsing default return to data.
	 *
	 * @param $path
	 *
	 * @return Mixed
	 * @throws WrongArrayPathException
	 */
	public function getOnly($path)
	{
		$arguments = func_get_args();

		isset( $arguments[1] ) && $default_return = $arguments[1];

		try
		{
			return $this->get($path);
		}
		catch (WrongArrayPathException $e)
		{
			if ( isset( $default_return ) )
			{
				return $default_return;
			}

			throw $e;
		}
	}


	/**
	 * @param $rawPath
	 * @param $value
	 *
	 * @return Mixed|\Knot\Dict\ChildDict
	 */
	public function set($rawPath, $value)
	{
		$target_data =& $this->data;

		foreach (static::pathParser($rawPath) as $path)
		{
			// If there is no way to go or this is not an array!
			if ( ! isset( $target_data[$path] ) || ! is_array($target_data[$path]) )
			{
				$target_data[$path] = [ ];
			}

			$target_data =& $target_data[$path];
		}

		$target_data = $value;

		if ( is_array($target_data) )
		{
			return new ChildDict($target_data, $this->childParent(), $this->path());
		}

		return $value;
	}


	/**
	 * @param $rawPath
	 *
	 * @return $this
	 */
	public function del($rawPath)
	{
		$target_data =& $this->data;

		$paths = static::pathParser($rawPath);

		$target_key = array_pop($paths);

		foreach ($paths as $path)
		{
			// If there is no way to go or this is not an array!
			if ( ! isset( $target_data[$path] ) || ! is_array($target_data[$path]) )
			{
				return $this;
			}

			$target_data =& $target_data[$path];
		}

		if ( isset( $target_data[$target_key] ) )
		{
			unset( $target_data[$target_key] );
		}

		return $this;
	}

	/* ===============================================
	 * ===============================================
	 * Array Access Interface.
	 */

	/**
	 * @param mixed $offset
	 *
	 * @return boolean
	 */
	public function offsetExists($offset)
	{
		return $this->__isset($offset);
	}


	/**
	 * @param mixed $offset
	 *
	 * @return mixed
	 */
	public function &offsetGet($offset)
	{
		if ( is_null($offset) )
		{
			$this->data[] = [ ];

			return $this->data[$this->lastKey()];
		}

		return $this->data[$offset];
	}


	/**
	 * @param mixed $offset
	 * @param mixed $value
	 *
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		if ( is_null($offset) )
		{
			$this->data[] = $value;
		}
		else
		{
			$this->data[$offset] = $value;
		}
	}


	/**
	 * @param mixed $offset
	 *
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		$this->__unset($offset);
	}

	/* ===============================================
	 * ===============================================
	 * Countable Interface.
	 */

	/**
	 * @param int $mode
	 *
	 * @return int
	 */
	public function count($mode = COUNT_NORMAL)
	{
		return count($this->data, $mode);
	}


	/* ===============================================
	 * ===============================================
	 * IteratorAggregate Interface.
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->data);
	}
}

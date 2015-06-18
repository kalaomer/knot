<?php namespace Knot\Dict;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Knot\Exceptions\FunctionExecuteException;
use Knot\Exceptions\WrongArrayPathException;
use Knot\Exceptions\WrongFunctionException;

/**
 * PHP ArrayEqualHelper methods
 * @method $this merge( array $array1 = null, array $array2 = null, array $_ = null )
 * @method $this reverse()
 * @method $this values()
 *
 * PHP ArrayChangerHelper methods
 * @method mixed shift()
 * @method mixed unshift( mixed $variable )
 * @method mixed push( mixed $variable )
 */
abstract class AbstractDictBody implements Arrayaccess, Countable, IteratorAggregate {

	use ArrayAccessTrait, CountableTrait, IteratorAggregateTrait, PathOperationsTrait;

	/**
	 * @var AbstractDictBody
	 */
	protected $parentArray;

	/**
	 * @var string
	 */
	protected $path = '';


	/**
	 * @return AbstractDictBody
	 */
	abstract public function kill();


	/**
	 * @param array            $data
	 * @param AbstractDictBody $parent
	 * @param                  $path
	 */
	public function __construct(array &$data, AbstractDictBody $parent = null, $path = '')
	{
		$this->data        =& $data;
		$this->path        = $path;
		$this->parentArray = $parent;
	}


	/**
	 * @param $key
	 * @param $value
	 */
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
	 * @param string $method
	 * @param array  $arguments
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function call($method, array $arguments = [ ])
	{
		if ( ! $this->keyExists($method) || ! is_callable($this->data[$method]) )
		{
			throw new WrongFunctionException("Wrong function or not callable key!");
		}

		$function = $this->data[$method];

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
		return $this->get($path);
	}


	/**
	 * Only search own data keys.
	 *
	 * @param mixed $key
	 *
	 * @return bool
	 */
	public function keyExists($key)
	{
		return isset( $this->data[$key] );
	}


	/**
	 * @return HelperManager
	 */
	public function getHelperManager()
	{
		return HelperManager::getInstance();
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


	/**
	 * @return ParentDict
	 */
	public function copy()
	{
		$_data = $this->data;

		return new ParentDict($_data, null, '');
	}


	/**
	 * @return $this
	 */
	public function childParent()
	{
		return $this;
	}

}

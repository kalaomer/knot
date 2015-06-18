<?php namespace Knot\Dict;

use Knot\Exceptions\WrongArrayPathException;

trait PathOperationsTrait {

	/**
	 * For parsing array path.
	 */
	public static $ARRAY_PATH_DELIMITER = ".";

	/**
	 * @var string
	 */
	protected $path = '';


	abstract public function childParent();


	/**
	 * @param null $add
	 *
	 * @return null|string
	 */
	public function path($add = null)
	{
		return $add ? $this->path != null ? $this->path . self::$ARRAY_PATH_DELIMITER . $add : $add : $this->path;
	}


	/**
	 * @param $path
	 *
	 * @return array
	 */
	public static function pathParser($path)
	{
		return explode(self::$ARRAY_PATH_DELIMITER, $path);
	}


	/**
	 * @param array $path
	 *
	 * @return string
	 */
	public static function pathCombiner(array $path)
	{
		return implode(self::$ARRAY_PATH_DELIMITER, $path);
	}


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


	/**
	 * @param $path
	 *
	 * @return array|ChildDict|Mixed
	 * @throws WrongArrayPathException
	 */
	public function get($path)
	{
		$arguments = func_get_args();

		if ( isset( $arguments[1] ) )
		{
			$default_return = $arguments[1];
		}

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

		if ( isset( $arguments[1] ) )
		{
			$value = $arguments[1];
		}

		try
		{
			return $this->get($path);
		}
		catch (WrongArrayPathException $e)
		{
			if ( isset( $value ) )
			{
				return $this->value($value, [ $path ]);
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

		$value = $this->value($value, [ $rawPath ]);

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


	protected function value($value, array $arguments = [ ])
	{
		return $value instanceof \Closure ? call_user_func_array($value, $arguments) : $value;
	}
}
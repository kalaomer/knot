<?php
/*
 * Main Knot class.
 */
namespace Knot;

class ParentArray extends \Knot implements \Arrayaccess {

	/**
	 * İçeriğin tutulduğu yer.
	 */
	Protected $data;

	Protected $parent_array;

	Protected $path = '';

	/**
	 * Çıktılarının içeriğe eşitlendiği fonksiyonlar.
	 * Örnek şablon: func( $data, ... );
	 * $data = func(...)
	 * return Knot( $data )
	 * @var array
	 */
	Public static $array_funcs_1 = array(
		"array_change_key_case",
		"array_chunk",
		"array_combine",
		"array_diff_assoc",
		"array_diff_key",
		"array_diff_uassoc",
		"array_diff_ukey",
		"array_diff",
		"array_fill_keys",
		"array_filter",
		"array_flip",
		"array_intersect_assoc",
		"array_intersect_key",
		"array_intersect_uassoc",
		"array_intersect_ukey",
		"array_intersect",
		"array_merge_recursive",
		"array_merge",
		"array_pad",
		"array_reverse",
		"array_slice",
		"array_udiff_assoc",
		"array_udiff_uassoc",
		"array_udiff",
		"array_uintersect_assoc",
		"array_uintersect_uassoc",
		"array_uintersect",
		"array_unique"
	);

	/**
	 * Örnek şablon: func( &$data, ... );
	 * $data != func(...)
	 * return func(...)
	 * @var array
	 */
	Public static $array_funcs_2 = array(
		"array_column",
		"array_count_values",
		"array_keys",
		"array_multisort",
		"array_pop",
		"array_product",
		"array_push",
		"array_rand",
		"array_reduce",
		"array_replace_recursive",
		"array_replace",
		"array_shift",
		"array_splice",
		"array_sum",
		"array_unshift",
		"array_values",
		"array_walk_recursive",
		"array_walk"
	);

	Public function __construct(&$data, $father, $path)
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
	 * @param mixed $key
	 * @return \Knot\ChildArray
	 * @throws \Exception
	 */
	Public function &__get($key)
	{
		try
		{
			$target =& $this->data[$key];

			if (is_array($target))
			{
				$r = new ChildArray($target, $this, $this->path($key));
				return $r;
			}

			return $target;
		}
		catch(\Exception $e)
		{
			throw $e;	
		}
	}

	/**
	 * Function list: PHP array functions + Callable Data + Helper Libraries!
	 * @param $method
	 * @param array $arguments
	 * @return $this|bool|mixed
	 * @throws \Exception
	 */
	Public function __call($method, $arguments = array())
	{
		$array_method = 'array_' . $method;

		if (in_array($array_method, self::$array_funcs_1))
		{
			array_unshift($arguments, $this->data);
			$this->data = call_user_func_array($array_method, $arguments);
			return $this;
		}

		if (in_array($array_method, self::$array_funcs_2))
		{
			$_data = array(&$this->data);
			return call_user_func_array($array_method, array_merge($_data, $arguments));
		}

		// If Callable Data in there, use it!
		if ($this->is_key($method) && is_callable($f = $this->data[$method]))
		{
			$_data = array(&$this->data);

			try {
				return call_user_func_array($f, array_merge($_data, $arguments));
			}
			catch(\Exception $e)
			{
				throw $e;
			}
		}

		try{
			return \Knot::$helper_manager->execute($method, $this->data, $arguments);
		}
		catch(\Exception $e)
		{
			throw $e;
		}

	}

	Public function __isset($key)
	{
		return isset($this->data[$key]);
	}

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
	 * Only search own data keys.
	 * @param mixed $key
	 * @return bool|false|true
	 */
	Public function is_key($key)
	{
		return isset($this->data[$key]);
	}

	/**
	 * @param $path
	 * @return bool
	 */
	Public function is_path($path)
	{
		try
		{
			$this->get($path);
			return true;
		}
		catch(Exceptions\WrongArrayPathException $e)
		{
			return false;
		}
	}

	/**
	 * For Get path without parsing default return to data.
	 *
	 * @param $path
	 * @return Mixed
	 * @throws Exceptions\WrongArrayPathException
	 */
	Public function only_get($path)
	{
		$arguments = func_get_args();

		if (isset($arguments[1]))
		{
			$default_return = $arguments[1];
		}

		try
		{
			return $this->get($path);
		}
		catch(Exceptions\WrongArrayPathException $e)
		{
			if (isset($default_return))
				return $default_return;

			throw $e;
		}
	}

	/**
	 * @param $path
	 * @param default_return
	 * @return Mixed|\Knot\ChildArray
	 * @throws Exceptions\WrongArrayPathException
	 */
	Public function &get($path)
	{

		$arguments = func_get_args();

		if (isset($arguments[1]))
		{
			$default_return = $arguments[1];
		}

		//	Hedef olarak ile data'yı seç.
		$target_data = &$this->data;

		foreach (self::pathParser($path) as $way)
		{
			if (!isset($target_data[$way]))
			{
				if ( isset($default_return) )
				{

					$this->set($path, $default_return);

					if (is_array($default_return))
					{
						$r = new ChildArray($default_return, $this, $path);
						return $r;
					}
					
					return $default_return;
				}
				//	default basılması isstenmiyorsa ise..
				else
				{
					throw new Exceptions\WrongArrayPathException('Path can\'t find! Path:' . $path);
				}
			}

			$target_data = &$target_data[$way];
		}

		// Eğer hedef Array ise ve çıktı türü otomatikse, Knot çocuğu olarak dön!
		if (is_array($target_data))
		{
			$r = new ChildArray($target_data, $this, $path);
			return $r;
		}

		return $target_data;
	}

	/**
	 * @param $rawPath
	 * @param $value
	 * @return Mixed|\Knot\Child
	 */
	Public function set($rawPath, $value)
	{
		$target_data =& $this->data;

		foreach (self::pathParser($rawPath) as $path)
		{
			// Eğer yol yok ise veya yol var ama array değilse!
			if (!isset($target_data[$path]) || !is_array($target_data[$path]))
			{
				$target_data[$path] = array();
			}

			$target_data =& $target_data[$path];
		}

		$target_data = $value;

		if(is_array($target_data))
		{
			return new ChildArray($target_data, $this, $this->path());
		}

		return $value;
	}

	Public function del($rawPath)
	{
		$target_data =& $this->data;

		$paths = self::pathParser($rawPath);

		$target_key = array_pop($paths);

		foreach ($paths as $path)
		{
			// Eğer yol yok ise veya yol var ama array değilse!
			if (!isset($target_data[$path]) || !is_array($target_data[$path]))
				return;

			$target_data =& $target_data[$path];
		}

		if (isset($target_data[$target_key]))
		{
			unset($target_data[$target_key]);
		}
	}

	/**
	 * Reset data!
	 * @return void
	 */
	Public function kill()
	{
		$this->data = array();
	}

	Public function path($add = null)
	{
		return $add ?
			$this->path != null ? $this->path . self::ARRAY_PATH_DELIMITER . $add :  $add
			:
			$this->path;
	}

	Public static function pathParser($path)
	{
		return explode(self::ARRAY_PATH_DELIMITER, $path);
	}

	Public static function pathCombiner(array $path)
	{
		return implode(self::ARRAY_PATH_DELIMITER, $path);
	}

	Public function last_key()
	{
		end( $this->data );
		return key( $this->data );
	}

	Public function &toArray()
	{
		return $this->data;
	}

	Public function copy()
	{
		$_data = $this->data;
		return new self($_data, null, '');
	}

	/* =============================================================================================================
	 * =============================================================================================================
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
		return $this->data[$offset];
	}

	/**
	* @param mixed $offset
	* @param mixed $value
	* @return void
	*/
	Public function offsetSet( $offset,  $value )
	{
		if ( is_null( $offset ) )
		{
			$this->data[]= $value;
		}
		else
		{
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
}
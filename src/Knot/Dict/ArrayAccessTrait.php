<?php namespace Knot\Dict;

trait ArrayAccessTrait {

	protected $data = [ ];


	abstract public function __unset($index);


	abstract public function __isset($index);


	abstract public function lastKey();


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
	public function &offsetGet($offset = null)
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
}
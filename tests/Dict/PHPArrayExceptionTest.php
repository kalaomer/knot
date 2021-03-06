<?php

class PHPArrayExceptionTest extends PHPUnit_Framework_TestCase {

	protected $objArray = array(
		1,
		2,
		3,
		"foo"    => array(
			"sub"     => array(
				"vuu" => "uuuuvvv"
			),
			"another" => "pff"
		),
		"my"     => array(
			"name",
			"is",
			"Knot!"
		),
		"string" => "info.."
	);


	/**
	 * @dataProvider simpleObj
	 * @expectedException \Knot\Exceptions\WrongArrayPathException
	 */
	public function testGetManually($obj)
	{
		$obj->__get('asd');
	}


	/**
	 * @dataProvider simpleObj
	 * @expectedException Exception
	 */
	public function testCallDataCallable($obj)
	{
		$obj->f = function ($a, $b)
		{

		};

		$obj->f();
	}


	/**
	 * @expectedException \Knot\Exceptions\WrongFunctionException
	 */
	public function testFunction()
	{
		$obj = ar();

		$obj->noway();
	}


	/**
	 * @dataProvider simpleObj
	 * @expectedException \Knot\Exceptions\FunctionExecuteException
	 */
	public function testHelperFunction($obj)
	{
		$obj->merge(1, 2, 3);
	}


	public function simpleObj()
	{
		return array(
			array( arr($this->objArray) )
		);
	}
}
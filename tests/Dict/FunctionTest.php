<?php

class FunctionTest extends PHPUnit_Framework_TestCase {

	public function testAr()
	{
		$this->assertEquals(array(1, 2, 3), ar(1, 2, 3)->toArray());
	}

	public function testArr()
	{
		$this->assertEquals(array(1, 2, 3), arr(array(1, 2, 3))->toArray());
	}

	public function testArrRef()
	{
		$array = array(1, 2, 3);
		$obj = arrRef($array);
		$this->assertSame($array, $obj->toArray());
	}

	public function testIsDict()
	{
		$intVariable = 1;

		$this->assertFalse(is_dict($intVariable));

		$dict = ar();

		$this->assertTrue(is_dict($dict));
	}
}

<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/20/14
 * Time: 2:16 PM
 */

class PHPArrayFunctionsTest extends PHPUnit_Framework_TestCase {

	Public function testArrayMerge()
	{
		$obj = ar();

		$obj->merge(array(1,2,3), array(4,5,6));

		$this->assertEquals(array(1,2,3,4,5,6), $obj->toArray());

		$obj->kill();

		$obj->merge(array("a" => "A"))->merge(array("b" => "B"));

		$this->assertEquals(array("a" => "A", "b" => "B"), $obj->toArray());
	}

	Public function testArrayShift()
	{
		$obj = ar(1,2,3);

		$this->assertEquals(1, $obj->shift());

		$this->assertEquals(array(2,3), $obj->toArray());
	}

	Public function testArrayUnshift()
	{
		$obj = ar(2,3);

		$this->assertEquals(3, $obj->unshift(1));

		$this->assertEquals(array(1,2,3), $obj->toArray());
	}

	Public function testArrayUnique()
	{
		$obj = arr($array = array(
			"a" => "green", "red", "b" => "green", "blue", "red", "blue"
		));

		$obj->unique();

		$this->assertEquals(array_unique($array), $obj->toArray());
	}
}
 
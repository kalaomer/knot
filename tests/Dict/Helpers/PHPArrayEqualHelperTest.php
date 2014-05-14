<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/20/14
 * Time: 2:16 PM
 */

class PHPArrayEqualHelperTest extends PHPUnit_Framework_TestCase {

	public function testArrayMerge()
	{
		$obj = ar();

		$obj->merge(array(1,2,3), array(4,5,6));

		$this->assertEquals(array(1,2,3,4,5,6), $obj->toArray());

		$obj->kill();

		$obj->merge(array("a" => "A"))->merge(array("b" => "B"));

		$this->assertEquals(array("a" => "A", "b" => "B"), $obj->toArray());
	}

	public function testArrayUnique()
	{
		$obj = arr($array = array(
			"a" => "green", "red", "b" => "green", "blue", "red", "blue"
		));

		$obj->unique();

		$this->assertEquals(array_unique($array), $obj->toArray());
	}

	public function testArrayMergeRecursive()
	{
		$obj = ar();

		$equals = array_merge_recursive(array(1,2,3), array(3,4,5));
		$result = $obj->mergeRecursive(array(1,2,3), array(3,4,5))->toArray();
		
		$this->assertEquals($equals, $result);
	}
}
 
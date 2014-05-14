<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/19/14
 * Time: 2:53 PM
 */

class UnderscoreHelperTest extends PHPUnit_Framework_TestCase {

	protected $objArray = array(
		array(
			'name'    =>  'Joe Bloggs',
			'id'      =>  1,
			'grade'   =>  72,
			'class'   =>  'A',
		),
		array(
			'name'    =>  'Jack Brown',
			'id'      =>  2,
			'grade'   =>  67,
			'class'   =>  'B',
		),
		array(
			'name'    =>  'Jill Beaumont',
			'id'      =>  3,
			'grade'   =>  81,
			'class'   =>  'B',
		),
	);

	/**
	 * @dataProvider simpleObj
	 */
	public function testFind($obj)
	{
		$this->assertEquals($this->objArray[2], $obj->find(
			function($student) {
				return $student["grade"] == 81;
			}
		));
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testGroupBy($obj)
	{
		$this->assertEquals(array(
			"A" => array(
				$this->objArray[0]
			),
			"B" => array(
				$this->objArray[1],
				$this->objArray[2]
			)
		), $obj->groupBy("class"));
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testTemplate($obj)
	{
		$name = "Jack";

	}

	public function simpleObj()
	{
		return array(
			array(arr($this->objArray))
		);
	}
}
 
<?php

/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/22/14
 * Time: 1:00 PM
 */
class ParentChildRelationsTest extends PHPUnit_Framework_TestCase {

	public function testParent()
	{
		$parent = ar();

		$parent["child"] = array(
			"new" => array(
				"way" => array( "foo" )
			)
		);

		$child = $parent->child;

		$this->assertSame($child->parent(), $parent);

		$new = $child->new;

		$this->assertSame($new->parent(), $parent);

		$this->assertEquals($new->parent()->child->toArray(), $parent->child->toArray());

	}
}
 
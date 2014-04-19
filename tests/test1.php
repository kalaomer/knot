<?php

header('Content-Type: text/html; charset=utf-8');

require_once dirname(__DIR__) . "/vendor/autoload.php";

/*
 * Test of Easy Array.
 */

$a = [];

$b =& $a["asd"];
print_r($a);
var_dump($b);
$a["b"] = 0;

var_dump(isset($a["b"]));
die();

$parent = new Easyarray\Father([1,2,3]);

print_r($parent);

die();

$new_array = ar(
	array('name' => 'something','surname' => 'aaa'),
	array('name' => 'something','surname' => 'baa'),
	array('name' => 'something','surname' => 'caa'),
	array('name' => 'something','surname' => 'daa'),
	array('name' => 'Rasmus','surname' => 'Lerdorf'),
	array('name' => 'Zero','surname' => 'One')
);

$new_array->order_by('name DESC,surname ASC')->dump( "new_array order_by" );

var_dump( "new_array toJSON", $new_array->toJSON() );

$child( function() use ( $child ) {
			return $child->merge( ["function say HELLO!"] );
		} )
			->father()
			->dump("father after invoke function");


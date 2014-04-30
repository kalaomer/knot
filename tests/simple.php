<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/20/14
 * Time: 3:38 PM
 */

require_once 'bootstrap.php';

$parent = ar(1,2,3)->merge(array(3,3,4,5,6,7))->unique();

$parent->child = array("a", "b", "c");

$child = $parent->child;

$child['new']['way'] = 1;

var_dump($parent->toArray());
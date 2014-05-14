<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DataTest extends PHPUnit_Framework_TestCase {
    
    public function testConstruct()
    {
        $helper = new \Knot\Dict\HelperManager();
        $this->assertAttributeNotEmpty('helpers', $helper);
    }
}

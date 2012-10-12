<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

require_once 'PHPUnit/Framework/TestCase.php';

class Net_GeoIP_LocationTest extends PHPUnit_Framework_TestCase
{

    public function testShouldHaveBetterTestCoverage() {
        $this->markTestIncomplete('public function __get($name)
public function __isset($name)
public function __toString()
public function distance(Net_GeoIP_Location $loc)
public function getData()
public function serialize()
public function set($name, $val)
public function unserialize($serialized)');
    }
}
<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class DirectiveCastToStringTest extends PHPUnit_Framework_TestCase {

    public function testCastingToString() { 
        $directive = new \webignition\RobotsTxt\Directive\Directive();
        $directive->setField('allow');
        $directive->setValue('/allowed-path');
        
        $this->assertEquals('allow:/allowed-path', (string)$directive);        
    }
}
<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class DirectiveParseFromStringTest extends PHPUnit_Framework_TestCase {

    public function testParseFromString() { 
        $directive = new \webignition\RobotsTxt\Directive\Directive();
        $directive->parse('allow:/allowed-path');
        
        $this->assertEquals('allow', (string)$directive->getField());
        $this->assertEquals('/allowed-path', (string)$directive->getValue());
    }

}
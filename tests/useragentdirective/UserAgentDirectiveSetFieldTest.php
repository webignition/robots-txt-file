<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class UserAgentDirectiveSetFieldTest extends PHPUnit_Framework_TestCase {
    
    public function testFieldValueRemainsConstant() {
        $directive = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirective();
        
        $this->assertEquals('user-agent', (string)$directive->getField());        
        
        $directive->setField();
        $this->assertEquals('user-agent', (string)$directive->getField());
        
        $directive->setField('ignored');
        $this->assertEquals('user-agent', (string)$directive->getField());        
    }    
}
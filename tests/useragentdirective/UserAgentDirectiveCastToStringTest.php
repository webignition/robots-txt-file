<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class UserAgentDirectiveCastToStringTest extends PHPUnit_Framework_TestCase {

    public function testCastUserAgentDirectiveToString() { 
        $userAgentDirective = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirective();        
        
        $this->assertEquals('user-agent:*', (string)$userAgentDirective);
    }
    
//    public function testCastUserAgentDirectiveListToString() {
//        $list = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirectiveList();
//        
//        $list->add('googlebot');
//        $list->add('slurp');
//        
//        $this->assertEquals('user-agent:googlebot'."\n".'user-agent:slurp', (string)$list);        
//    }
}
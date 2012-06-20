<?php
namespace webignition\RobotsTxt\UserAgentDirective;

class UserAgentDirective extends \webignition\RobotsTxt\Directive\Directive {
    
    const USER_AGENT_FIELD_VALUE = 'user-agent';
    
    public function __construct() {
        $this->setField();
    }

    public function setField() {
        parent::setField(self::USER_AGENT_FIELD_VALUE);
    }
    
}
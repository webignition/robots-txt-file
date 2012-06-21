<?php
namespace webignition\RobotsTxt\UserAgentDirective;

class UserAgentDirective extends \webignition\RobotsTxt\Directive\Directive {
    
    const USER_AGENT_FIELD_VALUE = 'user-agent';
    const DEFAULT_USER_AGENT = '*';
    
    public function __construct() {
        $this->parse(self::USER_AGENT_FIELD_VALUE.self::FIELD_VALUE_SEPARATOR);
    }
    
    /**
     *
     * @return string
     */
    public function getField() {
        return strtolower(parent::getField());
    }
    
    
    /**
     *
     * @return string
     */
    public function getValue() {
        return parent::getValue() == '' ? self::DEFAULT_USER_AGENT : parent::getValue();
    }
    
}
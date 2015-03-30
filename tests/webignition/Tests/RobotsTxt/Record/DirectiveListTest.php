<?php

namespace webignition\Tests\RobotsTxt\Record;

class DirectiveListTest extends RecordTest {
    
    public function testDefaultDirectiveList() {
        $this->assertEquals(array(), $this->record->directiveList()->get());
    }
    
    public function testAddDirective() {
        $this->record->directiveList()->add('allow:/allowed-path');
        
        $this->assertEquals(array('allow:/allowed-path'), $this->record->directiveList()->get());
    }
    
    public function testRemoveDirective() {
        $this->record->directiveList()->add('allow:/allowed-path');
        $this->record->directiveList()->remove('allow:/allowed-path');
        
        $this->assertEquals(array(), $this->record->directiveList()->get());
    }    
    
}
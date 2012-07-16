<?php
ini_set('display_errors', 'On');

class DirectiveListTest extends PHPUnit_Framework_TestCase {
    
    public function testAdd() {
        $directiveList = new \webignition\RobotsTxt\DirectiveList\DirectiveList();
        
        $directiveList->add('allow:/allowed-path');        
        $this->assertEquals(array('allow:/allowed-path'), $directiveList->getValues());
        
        $directiveList->add('disallow:/disallowed-path');
        $this->assertEquals(array('allow:/allowed-path', 'disallow:/disallowed-path'), $directiveList->getValues());
    }
    
    public function testRemove() {
        $directiveList = new \webignition\RobotsTxt\DirectiveList\DirectiveList();
        
        $directiveList->add('field1:value1');                
        $directiveList->add('field2:value2');
        $directiveList->add('field3:value3');        
        $this->assertEquals(array('field1:value1', 'field2:value2', 'field3:value3'), $directiveList->getValues());
        
        $directiveList->remove('fieLD1:value1');
        $this->assertEquals(array('field2:value2', 'field3:value3'), $directiveList->getValues());
        
        $directiveList->remove('field2:value2');
        $this->assertEquals(array('field3:value3'), $directiveList->getValues());
        
        $directiveList->remove('fielD3:value3');
        $this->assertEquals(array(), $directiveList->getValues());        
    }
    
    public function testContains() {
        $directiveList = new \webignition\RobotsTxt\DirectiveList\DirectiveList();
        
        $directiveList->add('field1:value1');                
        $directiveList->add('field2:value2');
        $directiveList->add('field3:value3'); 
        
        $this->assertTrue($directiveList->contains('field1:value1'));
        $this->assertTrue($directiveList->contains('fIeld2:value2'));
        $this->assertTrue($directiveList->contains('fiELd3:value3'));        
        $this->assertFalse($directiveList->contains('doesnotcontain:value'));
    }
    
    public function testGetByField() {
        $directiveList = new \webignition\RobotsTxt\DirectiveList\DirectiveList();
        
        $directiveList->add('allow:/allow-path-1');                
        $directiveList->add('allow:/allow-path-2');
        $directiveList->add('allow:/allow-path-3');
        $directiveList->add('disallow:/disallow-path-1');                
        $directiveList->add('disallow:/disallow-path-2');
        $directiveList->add('disallow:/disallow-path-3');        
        $directiveList->add('sitemap:/one.xml');                
        $directiveList->add('sitemap:/two.xml');
        $directiveList->add('sitemap:/three.xml');
        
        $this->assertEquals('allow:/allow-path-1'."\n".'allow:/allow-path-2'."\n".'allow:/allow-path-3', (string)$directiveList->filter(array('field' => 'allow')));
        $this->assertEquals('disallow:/disallow-path-1'."\n".'disallow:/disallow-path-2'."\n".'disallow:/disallow-path-3', (string)$directiveList->filter(array('field' => 'disallow')));
        $this->assertEquals('sitemap:/one.xml'."\n".'sitemap:/two.xml'."\n".'sitemap:/three.xml', (string)$directiveList->filter(array('field' => 'sitemap')));
    }   
    
}
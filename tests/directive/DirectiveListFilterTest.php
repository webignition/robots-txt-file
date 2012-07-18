<?php

class DirectiveListFilterTest extends PHPUnit_Framework_TestCase {
    
    public function testFilter() {
        $directiveList = new \webignition\RobotsTxt\DirectiveList\DirectiveList();
        
        $directiveList->add('allow:/allow-path-1');                
        $directiveList->add('allow:/allow-path-2');
        $directiveList->add('disallow:/disallow-path-1');                
        $directiveList->add('disallow:/disallow-path-2');      
        $directiveList->add('sitemap:/one.xml');                
        $directiveList->add('sitemap:/two.xml');
        
        $filter = new \webignition\RobotsTxt\DirectiveList\Filter($directiveList);

        $this->assertEquals('allow:/allow-path-1'."\n".'allow:/allow-path-2', (string)($filter->getDirectiveList(array(
            'field' => 'allow'
        ))));
        
        $this->assertEquals('disallow:/disallow-path-1'."\n".'disallow:/disallow-path-2', (string)($filter->getDirectiveList(array(
            'field' => 'disallow'
        ))));
        
        $this->assertEquals('sitemap:/one.xml'."\n".'sitemap:/two.xml', (string)($filter->getDirectiveList(array(
            'field' => 'sitemap'
        ))));                
        
        $this->assertEquals('sitemap:/one.xml', (string)($filter->getDirectiveList(array(
            'field' => 'sitemap',
            'value' => '/one.xml'
        ))));        
        
        $this->assertEquals('sitemap:/one.xml', (string)($filter->getDirectiveList(array(
            'value' => '/one.xml'
        ))));         
    }
    
    
    
}
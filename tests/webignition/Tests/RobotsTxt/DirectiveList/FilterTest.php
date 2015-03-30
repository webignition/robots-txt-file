<?php

namespace webignition\Tests\RobotsTxt\DirectiveList;

use webignition\RobotsTxt\DirectiveList\Filter;

class FilterTest extends DirectiveListTest {
    
    public function testFilter() {
        $this->directiveList->add('allow:/allow-path-1');
        $this->directiveList->add('allow:/allow-path-2');
        $this->directiveList->add('disallow:/disallow-path-1');
        $this->directiveList->add('disallow:/disallow-path-2');
        $this->directiveList->add('sitemap:/one.xml');
        $this->directiveList->add('sitemap:/two.xml');
        
        $filter = new Filter($this->directiveList);

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
<?php

namespace webignition\Tests\RobotsTxt\DirectiveList;

class GetByFieldTest extends DirectiveListTest {

    public function testGetByField() {
        $this->directiveList->add('allow:/allow-path-1');
        $this->directiveList->add('allow:/allow-path-2');
        $this->directiveList->add('allow:/allow-path-3');
        $this->directiveList->add('disallow:/disallow-path-1');
        $this->directiveList->add('disallow:/disallow-path-2');
        $this->directiveList->add('disallow:/disallow-path-3');
        $this->directiveList->add('sitemap:/one.xml');
        $this->directiveList->add('sitemap:/two.xml');
        $this->directiveList->add('sitemap:/three.xml');
        
        $this->assertEquals('allow:/allow-path-1'."\n".'allow:/allow-path-2'."\n".'allow:/allow-path-3', (string)$this->directiveList->filter(array('field' => 'allow')));
        $this->assertEquals('disallow:/disallow-path-1'."\n".'disallow:/disallow-path-2'."\n".'disallow:/disallow-path-3', (string)$this->directiveList->filter(array('field' => 'disallow')));
        $this->assertEquals('sitemap:/one.xml'."\n".'sitemap:/two.xml'."\n".'sitemap:/three.xml', (string)$this->directiveList->filter(array('field' => 'sitemap')));
    }
    
}
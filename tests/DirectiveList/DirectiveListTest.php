<?php

namespace webignition\Tests\RobotsTxt\DirectiveList;

use webignition\RobotsTxt\Directive\Directive;
use webignition\Tests\RobotsTxt\BaseTest;
use webignition\RobotsTxt\DirectiveList\DirectiveList;

class DirectiveListTest extends BaseTest
{
    /**
     * @var DirectiveList
     */
    private $directiveList;

    protected function setUp()
    {
        $this->directiveList = new DirectiveList();
    }

    public function testAddWhereDirectiveIsNotAlreadyInList()
    {
        $directive = new Directive('field1', 'value1');
        $this->directiveList->add($directive);

        $this->assertEquals(1, $this->directiveList->getLength());
        $this->assertTrue($this->directiveList->contains($directive));
    }

    public function testAddWhereDirectiveIsAlreadyInList()
    {
        $directive = new Directive('field1', 'value1');
        $this->directiveList->add($directive);
        $this->directiveList->add($directive);

        $this->assertEquals(1, $this->directiveList->getLength());
        $this->assertTrue($this->directiveList->contains($directive));
    }

    public function testContains()
    {
        $directive1 = new Directive('field1', 'value1');
        $directive2 = new Directive('field2', 'value2');
        $directive3 = new Directive('field3', 'value3');

        $this->directiveList->add($directive1);
        $this->directiveList->add($directive2);

        $this->assertTrue($this->directiveList->contains($directive1));
        $this->assertTrue($this->directiveList->contains($directive2));
        $this->assertFalse($this->directiveList->contains($directive3));
    }

    public function testCastToString()
    {
        $this->directiveList->add(new Directive('field1', 'value1'));
        $this->assertEquals('field1:value1', (string)$this->directiveList);

        $this->directiveList->add(new Directive('field2', 'value2'));
        $this->assertEquals('field1:value1'."\n".'field2:value2', (string)$this->directiveList);
    }

    public function testContainsField()
    {
        $directive = new Directive('field1', 'value1');

        $this->directiveList->add($directive);

        $this->assertTrue($this->directiveList->containsField('field1'));
        $this->assertFalse($this->directiveList->containsField('field2'));
    }

    public function testFirst()
    {
        $this->directiveList->add(new Directive('field1', 'value1'));
        $this->directiveList->add(new Directive('field2', 'value2'));

        $this->assertEquals('field1:value1', (string)$this->directiveList->first());
    }

    public function testRemove()
    {
        $directive1 = new Directive('field1', 'value1');
        $directive2 = new Directive('field2', 'value2');
        $directive3 = new Directive('field3', 'value3');

        $this->directiveList->add($directive1);
        $this->directiveList->add($directive2);
        $this->directiveList->add($directive3);
        $this->assertEquals(
            array('field1:value1', 'field2:value2', 'field3:value3'),
            $this->directiveList->getValues()
        );

        $this->directiveList->remove($directive1);
        $this->assertEquals(array('field2:value2', 'field3:value3'), $this->directiveList->getValues());

        $this->directiveList->remove($directive2);
        $this->assertEquals(array('field3:value3'), $this->directiveList->getValues());

        $this->directiveList->remove($directive3);
        $this->assertEquals(array(), $this->directiveList->getValues());
    }
}

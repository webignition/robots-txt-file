<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\DirectiveList;

use webignition\RobotsTxt\Directive\Directive;
use webignition\RobotsTxt\DirectiveList\DirectiveList;

class DirectiveListTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var DirectiveList
     */
    private $directiveList;

    protected function setUp(): void
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
        $this->assertEquals('field1:value1' . "\n" . 'field2:value2', (string)$this->directiveList);
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

    /**
     * @dataProvider getByFieldDataProvider
     *
     * @param array<string, array<string, string>> $directives
     * @param string $field
     * @param string $expectedDirectiveListString
     */
    public function testGetByField(array $directives, string $field, string $expectedDirectiveListString)
    {
        foreach ($directives as $directive) {
            $this->directiveList->add(new Directive($directive['field'], $directive['value']));
        }

        $this->assertEquals(
            $expectedDirectiveListString,
            (string)$this->directiveList->getByField($field)
        );
    }

    public function getByFieldDataProvider(): array
    {
        return [
            'none for empty list' => [
                'directives' => [],
                'field' => 'foo',
                'expectedDirectiveListString' => '',
            ],
            'none for no matches' => [
                'directives' => [
                    [
                        'field' => 'allow',
                        'value' => '/foo',
                    ],
                ],
                'field' => 'foo',
                'expectedDirectiveListString' => '',
            ],
            'one match' => [
                'directives' => [
                    [
                        'field' => 'allow',
                        'value' => '/foo',
                    ],
                ],
                'field' => 'allow',
                'expectedDirectiveListString' => 'allow:/foo',
            ],
            'many matches' => [
                'directives' => [
                    [
                        'field' => 'allow',
                        'value' => '/foo',
                    ],
                    [
                        'field' => 'disallow',
                        'value' => '/bar',
                    ],
                    [
                        'field' => 'allow',
                        'value' => '/foobar',
                    ],
                    [
                        'field' => 'disallow',
                        'value' => '/fizz',
                    ],
                    [
                        'field' => 'allow',
                        'value' => '/buzz',
                    ],
                ],
                'field' => 'allow',
                'expectedDirectiveListString' => 'allow:/foo' . "\n" . 'allow:/foobar' . "\n" . 'allow:/buzz',
            ],
        ];
    }
}

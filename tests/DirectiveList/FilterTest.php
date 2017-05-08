<?php

namespace webignition\Tests\RobotsTxt\DirectiveList;

use webignition\RobotsTxt\Directive\Directive;
use webignition\RobotsTxt\DirectiveList\DirectiveList;
use webignition\RobotsTxt\DirectiveList\Filter;
use webignition\Tests\RobotsTxt\BaseTest;

class FilterTest extends BaseTest
{
    /**
     * @var DirectiveList
     */
    private $directiveList;

    /**
     * @var Filter
     */
    private $filter;

    protected function setUp()
    {
        $this->directiveList = new DirectiveList();
        $this->filter = new Filter($this->directiveList);

        $allowDirective1 = new Directive('allow', '/allow-path-1');
        $allowDirective2 = new Directive('allow', '/allow-path-2');
        $disallowDirective1 = new Directive('disallow', '/disallow-path-1');
        $disallowDirective2 = new Directive('disallow', '/disallow-path-2');
        $sitemapDirective1 = new Directive('sitemap', '/one.xml');
        $sitemapDirective2 = new Directive('sitemap', '/two.xml');

        $this->directiveList->add($allowDirective1);
        $this->directiveList->add($allowDirective2);
        $this->directiveList->add($disallowDirective1);
        $this->directiveList->add($disallowDirective2);
        $this->directiveList->add($sitemapDirective1);
        $this->directiveList->add($sitemapDirective2);
    }

    /**
     * @dataProvider filterByFieldDataProvider
     *
     * @param string $field
     * @param string $expectedDirectiveListString
     */
    public function testFilterByField($field, $expectedDirectiveListString)
    {
        $filteredDirectives = $this->filter->getDirectiveList([
            'field' => $field
        ]);

        $this->assertEquals(
            $expectedDirectiveListString,
            (string)$filteredDirectives
        );
    }

    /**
     * @return array
     */
    public function filterByFieldDataProvider()
    {
        return [
            'allow' => [
                'field' => 'allow',
                'expectedDirectiveListString' => 'allow:/allow-path-1'."\n".'allow:/allow-path-2',
            ],
            'disallow' => [
                'field' => 'disallow',
                'expectedDirectiveListString' => 'disallow:/disallow-path-1'."\n".'disallow:/disallow-path-2',
            ],
            'sitemap' => [
                'field' => 'sitemap',
                'expectedDirectiveListString' => 'sitemap:/one.xml'."\n".'sitemap:/two.xml',
            ],
        ];
    }

    /**
     * @dataProvider filterByValueDataProvider
     *
     * @param string $value
     * @param string $expectedDirectiveListString
     */
    public function testFilterByValue($value, $expectedDirectiveListString)
    {
        $filteredDirectives = $this->filter->getDirectiveList([
            'value' => $value
        ]);

        $this->assertEquals(
            $expectedDirectiveListString,
            (string)$filteredDirectives
        );
    }

    /**
     * @return array
     */
    public function filterByValueDataProvider()
    {
        return [
            'first sitemap' => [
                'value' => '/one.xml',
                'expectedDirectiveListString' => 'sitemap:/one.xml',
            ],
            'second disallow' => [
                'value' => '/disallow-path-2',
                'expectedDirectiveListString' => 'disallow:/disallow-path-2',
            ],
        ];
    }

    /**
     * @dataProvider filterByFieldAndValueDataProvider
     *
     * @param string $field
     * @param string $value
     * @param string $expectedDirectiveListString
     */
    public function testFilterByFieldAndValue($field, $value, $expectedDirectiveListString)
    {
        $filteredDirectives = $this->filter->getDirectiveList([
            'field' => $field,
            'value' => $value
        ]);

        $this->assertEquals(
            $expectedDirectiveListString,
            (string)$filteredDirectives
        );
    }

    /**
     * @return array
     */
    public function filterByFieldAndValueDataProvider()
    {
        return [
            'second sitemap' => [
                'field' => 'sitemap',
                'value' => '/two.xml',
                'expectedDirectiveListString' => 'sitemap:/two.xml',
            ],
            'first sallow' => [
                'field' => 'allow',
                'value' => '/allow-path-1',
                'expectedDirectiveListString' => 'allow:/allow-path-1',
            ],
        ];
    }
}

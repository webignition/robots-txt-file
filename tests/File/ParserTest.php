<?php

namespace webignition\Tests\RobotsTxt\File;

use webignition\RobotsTxt\Directive\Directive;
use webignition\RobotsTxt\File\Parser;
use webignition\RobotsTxt\Inspector\Inspector;
use webignition\Tests\RobotsTxt\BaseTest;

class ParserTest extends BaseTest
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var string
     */
    private $dataSourceBasePath;

    protected function setUp()
    {
        parent::setUp();
        $this->parser = new Parser();
        $this->dataSourceBasePath = __DIR__ . '/../fixtures/robots-txt-files';
    }

    public function testParsingStackoverflowDotCom()
    {
        $this->setParserSourceFromDataFile('stackoverflow.com.txt');
        $file = $this->parser->getFile();
        $inspector = new Inspector($file);

        $this->assertNotEmpty((string)$file);

        $records = $file->getRecords();

        $this->assertCount(5, $records);

        $record1 = $records[0];

        $this->assertEquals(array('*'), $record1->getUserAgentDirectiveList()->getValues());
        $this->assertCount(48, $record1->getDirectiveList()->getDirectives());
        $this->assertTrue($record1->getDirectiveList()->contains(
            new Directive('disallow', '/users/login/global/request/'))
        );

        $inspector->setUserAgent('googlebot-image');
        $this->assertEquals(
            'disallow:/*/ivc/*'."\n".'disallow:/users/flair/',
            (string)$inspector->getDirectives()
        );
        $this->assertEquals(
            'sitemap:/sitemap.xml',
            (string)$file->getNonGroupDirectives()->getByField('sitemap')
        );
    }

    public function testParsingWithSitemapAsLastLineInSingleRecord()
    {
        $this->setParserSourceFromDataFile('sitemapAsLastLineInSingleRecord.txt');

        $file = $this->parser->getFile();

        $this->assertCount(1, $file->getRecords());
        $this->assertCount(1, $file->getNonGroupDirectives()->getValues());

        $this->assertEquals(
            'sitemap:http://example.com/sitemap.xml',
            (string)$file->getNonGroupDirectives()->getByField( 'sitemap')
        );
    }

    public function testParsingWithSitemapWithinSingleRecord()
    {
        $this->setParserSourceFromDataFile('sitemapWithinSingleRecord.txt');

        $file = $this->parser->getFile();
        $inspector = new Inspector($file);

        $this->assertCount(1, $file->getRecords());
        $this->assertCount(2, $inspector->getDirectives()->getValues());
        $this->assertCount(1, $file->getNonGroupDirectives()->getValues());

        $this->assertEquals(
            'sitemap:http://example.com/sitemap.xml',
            (string)$file->getNonGroupDirectives()->getByField('sitemap')
        );
    }

    public function testParsingInvalidSitemap()
    {
        $this->setParserSourceFromDataFile('newscientist.com.txt');

        $file = $this->parser->getFile();
        $inspector = new Inspector($file);

        $this->assertCount(2, $file->getRecords());
        $this->assertCount(1, $inspector->getDirectives()->getValues());

        $inspector->setUserAgent('zibber');
        $this->assertCount(6, $inspector->getDirectives()->getValues());
        $this->assertCount(1, $file->getNonGroupDirectives()->getValues());
        $this->assertCount(1, $file->getNonGroupDirectives()->getByField('sitemap')->getValues());
    }

    public function testParsingWithStartingBOM()
    {
        $this->setParserSourceFromDataFile('withBom.txt');

        $file = $this->parser->getFile();
        $inspector = new Inspector($file);

        $this->assertCount(1, $file->getRecords());
        $this->assertCount(2, $inspector->getDirectives()->getValues());

        $this->assertEquals(array(
            'disallow:/',
            'allow:/humans.txt'
        ), $inspector->getDirectives()->getValues());
    }

    /**
     * @param string $relativePath
     */
    private function setParserSourceFromDataFile($relativePath)
    {
        $this->parser->setSource(file_get_contents($this->dataSourceBasePath . '/' . $relativePath));
    }
}

<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class FileGenerlTest extends PHPUnit_Framework_TestCase {    

    public function testGetDirectivesFor() {
        
        $record1 = new \webignition\RobotsTxt\Record\Record();
        $record1->userAgentDirectiveList()->add('*');
        $record1->directiveList()->add('allow:/allowed-path-for-*');
        $record1->directiveList()->add('disallow:/disallowed-path-for-*');
        
        $record2 = new \webignition\RobotsTxt\Record\Record();
        $record2->userAgentDirectiveList()->add('googlebot');
        $record2->directiveList()->add('allow:/allowed-path-for-googlebot');
        $record2->directiveList()->add('disallow:/disallowed-path-for-googlebot');        
        
        
        $file = new \webignition\RobotsTxt\File\File();
        $file->addRecord($record1);
        $file->addRecord($record2);
        
        $this->assertEquals('allow:/allowed-path-for-googlebot'."\n".'disallow:/disallowed-path-for-googlebot', (string)$file->getDirectivesFor('googlebot'));
        $this->assertEquals('allow:/allowed-path-for-*'."\n".'disallow:/disallowed-path-for-*', (string)$file->getDirectivesFor('*'));
        $this->assertEquals('allow:/allowed-path-for-*'."\n".'disallow:/disallowed-path-for-*', (string)$file->getDirectivesFor('slurp'));
    }
}
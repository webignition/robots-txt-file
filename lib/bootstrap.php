<?php
namespace webignition\RobotsTxt;

// Enable maximum error reporting for unit tests
if (substr($_SERVER['SCRIPT_NAME'], (-1 * strlen('phpunit'))) === 'phpunit') {
    error_reporting(-1);
}

function autoload( $rootDir ) {
    spl_autoload_register(function( $className ) use ( $rootDir ) {        
        $file = sprintf(
            '%s/%s.php',
            $rootDir,
            str_replace( array('\\', '_'), '/', $className )
        );       
 
        if ( file_exists($file) ) {
            require $file;
        }
        

    });
}

autoload( '/usr/share/php' );
autoload( __DIR__ . '/../tests');
autoload( __DIR__ . '/../src');
autoload( __DIR__ . '/../vendor/webignition/disallowed-character-terminated-string/src');
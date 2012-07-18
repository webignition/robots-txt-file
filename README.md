robots-txt-file [![Build Status](https://secure.travis-ci.org/webignition/robots-txt-file.png?branch=master)](http://travis-ci.org/webignition/robots-txt-file)
===============

Overview
---------
Models a [robots.txt][1] file. Can use be used to build a minimal (commentless)
robots.txt file programmatically. Use with [robots-txt-parser][2] to extract
details from live robots.txt files.

Robots.txt file format refresher
--------------------------------

Let's quickly go over the format of a robots.txt file so that you can understand what you can get out of a `\webignition\RobotsTxt\File\File` object.

A robots.txt file contains a collection of **records**. A record provides a set of **directives** to a specified user agent. A directive instructs a user agent to do something (or not do something). A blank line is used to separate records.

Here's an example with two records:

    User-agent: Slurp
    Disallow: /

    User-Agent: *
    Disallow: /private

This instructs the user agent 'Slurp' that it is not allowed access to '/' (i.e. the whole site), and this instructs all other user agents that they are not allowed access to '/private'.

A robots.txt file can optionally contain directives that apply to all user agents irrespective of the specified records. These are included as a set of a directives that are not part of a record. A common use is the `sitemap` directive.

Here's an example with directives that apply to everyone and everything:

    User-agent: Slurp
    Disallow: /

    User-Agent: *
    Disallow: /private

    Sitemap: http://example.com/sitemap.xml

Usage
-----

A `\webignition\RobotsTxt\File\File` object, preferably populated via a [robots-txt-parser][2], provides immediate access to a robots.txt file's set of records and set of directives that don't belong to any records.

```php
<?php
    $parser = new \webignition\RobotsTxt\File\Parser();
    $parser->setContent(file_get_contents('http://example.com/robots.txt'));

    $robotsTxtFile = $parser->getFile();
 
    # Get an array of records
    $robotsTxtFile->getRecords();

    # Get the list of record-independent directives (such as sitemap directives):
    $robotsTxtFile->directiveList()->get();
```


Building
--------

#### Using as a library in a project

If used as a dependency by another project, update that project's composer.json
and update your dependencies.

    "require": {
        "webignition/robots-txt-file": "*"      
    }

#### Developing

This project has external dependencies managed with [composer][3]. Get and install this first.

    # Make a suitable project directory
    mkdir ~/robots-txt-file && cd ~/robots-txt-file

    # Clone repository
    git clone git@github.com:webignition/robots-txt-file.git.

    # Retrieve/update dependencies
    composer.phar update

Testing
-------

Have look at the [project on travis][4] for the latest build status, or give the tests
a go yourself.

    cd ~/robots-txt-file
    phpunit


[1]: http://www.robotstxt.org/
[2]: https://github.com/webignition/robots-txt-parser
[3]: http://getcomposer.org
[4]: http://travis-ci.org/webignition/robots-txt-file/builds
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

This might not be too useful on it's own. You'd normally be retrieving information from a robots.txt file because
you are a crawler and need to know what you are allowed to access (or disallowed) or because you're a tool or
service that needs to locate a site's sitemap.xml file.

Let's say we're the 'Slurp' user agent and we want to know what's been specified for us:

```php
<?php
$parser = new \webignition\RobotsTxt\File\Parser();
$parser->setContent(file_get_contents('http://example.com/robots.txt'));

$robotsTxtFile = $parser->getFile();
 
$slurpDirectiveList = $robotsTxtFile->getDirectivesFor('slurp');
```

Ok, now we have a [DirectiveList](https://github.com/webignition/robots-txt-file/blob/master/src/webignition/RobotsTxt/DirectiveList/DirectiveList.php)
containing a collection of directives. We can call `$directiveList->get()` to get the directives applicable to us.

Notice how the user agent string is case insensitive?

Let's say we're an automated web frontend testing service and we need to find a site's sitemap.xml to find a list
of URLs that need testing. We know the site's domain and we know where to look for the robots.txt file and we know
that this might specify the location of the sitemap.xml file.

```php
<?php
$parser = new \webignition\RobotsTxt\File\Parser();
$parser->setContent(file_get_contents('http://example.com/robots.txt'));

$robotsTxtFile = $parser->getFile();

$sitemapDirectives = $robotsTxtFile->directiveList()->filter(array('field' => 'sitemap'))->get();
$sitemapUrl = (string)$sitemapDirectives[0]->getValue();
```

Cool, we've found the URL for the first sitemap listed in the robots.txt file. There may be many, although just the one
is most common.

Did you spot the call to `DirectiveList->filter()`? That's a `DirectiveList\Filter` at work making it easy to trim down
a given `DirectiveList` to something more relevant.  You just pass the filter an array of keys and values, the key is
name of the thing you're filtering against, the value is the value you want to match.

Let's get all the `disallow` directives for Slurp:

```php
<?php
$slurpDisallowDirectiveList = $robotsTxtFile->getDirectivesFor('slurp')->filter(array('field' => 'disallow'))->get();
```

A directive has a field (disallow, allow, sitemap) and a value. We can filter against values too, although the value of
this is somewhat academic:

```php
<?php
$slurpDisallowDirectiveList = $robotsTxtFile->getDirectivesFor('slurp')->filter(array('value' => '/'))->get();
$sitemapDirectivesByUrl = $robotsTxtFile->directiveList()->filter(array('value' => 'http://example.com/sitemap.xml'))->get();
```

Building
--------

#### Using as a library in a project

If used as a dependency by another project, update that project's composer.json
and update your dependencies.

    "require": {
        "webignition/robots-txt-file": "dev-master"      
    }
    
If you want to be doing any parsing of robots.txt files (which you quote often would),
you need to get the parser too:

    "require": {
        "webignition/robots-txt-file": "dev-master",
        "webignition/robots-txt-parser": "dev-master" 
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

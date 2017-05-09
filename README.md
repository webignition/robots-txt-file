# robots-txt-file [![Build Status](https://secure.travis-ci.org/webignition/robots-txt-file.png?branch=master)](http://travis-ci.org/webignition/robots-txt-file)

- [Introduction](#introduction)
  - [Overview](#overview)
  - [Robots.txt file format refresher](#robots.txt-file-format-refresher)
- [Usage](#usage)
  - [Parsing a robots.txt file from a string into a model](#parsing-a-robots.txt-file-from-a-string-into-a-model)
  - [Inspecting a model to get directives for a user agent](#inspecting-a-model-to-get-directives-for-a-user-agent)
  - [Check if a user agent is allowed to access a url path](#check-if-a-user-agent-is-allowed-to-access-a-url-path)
  - [Extract sitemap URLs](#extract-sitemap-urls)
  - [Filtering directives for a user agent to a specific field type](#filtering-directives-for-a-user-agent-to-a-specific-field-type)
- [Building](#building)
  - [Using as a library in a project](#using-as-a-library-in-a-project)
  - [Developing](#developing)
  - [Testing](#testing)
  
## Introduction  

### Overview

Handles [robots.txt][1] files:

 - parse a robots.txt file into a model
 - get directives for a user agent
 - check if a user agent is allowed to access a url path
 - extract sitemap URLs
 - programmatically create a model and cast to a string

### Robots.txt file format refresher

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

## Usage

### Parsing a robots.txt file from a string into a model
```php
<?php
use webignition\RobotsTxt\File\Parser;

$parser = new Parser();
$parser->setSource(file_get_contents('http://example.com/robots.txt'));

$robotsTxtFile = $parser->getFile();
 
// Get an array of records
$robotsTxtFile->getRecords();

// Get the list of record-independent directives (such as sitemap directives):
$robotsTxtFile->getNonGroupDirectives()->get();
```

This might not be too useful on it's own. You'd normally be retrieving information from a robots.txt file because
you are a crawler and need to know what you are allowed to access (or disallowed) or because you're a tool or
service that needs to locate a site's sitemap.xml file.

### Inspecting a model to get directives for a user agent

Let's say we're the 'Slurp' user agent and we want to know what's been specified for us:

```php
<?php
use webignition\RobotsTxt\File\Parser;
use webignition\RobotsTxt\Inspector\Inspector;

$parser = new Parser();
$parser->setSource(file_get_contents('http://example.com/robots.txt'));

$inspector = new Inspector($parser->getFile());
$inspector->setUserAgent('slurp');

$slurpDirectiveList = $inspector->getDirectives();
```

Ok, now we have a [DirectiveList](https://github.com/webignition/robots-txt-file/blob/master/src/webignition/RobotsTxt/DirectiveList/DirectiveList.php)
containing a collection of directives. We can call `$directiveList->get()` to get the directives applicable to us.

This raw set of directives is available in the model because it is
there in the source robots.txt file. Often this raw data isn't
immediately useful as-is. Maybe we want to inspect it further?

### Check if a user agent is allowed to access a url path

That's more like it, let's inspect some of that data in the model.

```php
<?php
use webignition\RobotsTxt\File\Parser;
use webignition\RobotsTxt\Inspector\Inspector;

$parser = new Parser();
$parser->setSource(file_get_contents('http://example.com/robots.txt'));

$inspector = new Inspector($parser->getFile());
$inspector->setUserAgent('slurp');

if ($inspector->isAllowed('/foo')) {
    // Do whatever is needed access to /foo is allowed
}
```

### Extract sitemap URLs

A robots.txt file can list the URLs of all relevant sitemaps. These directives
are not specific to a user agent.

Let's say we're an automated web frontend testing service and we need to find a site's sitemap.xml to find a list
of URLs that need testing. We know the site's domain and we know where to look for the robots.txt file and we know
that this might specify the location of the sitemap.xml file.

```php
<?php
use webignition\RobotsTxt\File\Parser;

$parser = new Parser();
$parser->setSource(file_get_contents('http://example.com/robots.txt'));

$robotsTxtFile = $parser->getFile();

$sitemapDirectives = $robotsTxtFile->getNonGroupDirectives()->getByField('sitemap');
$sitemapUrl = (string)$sitemapDirectives->first()->getValue();
```

Cool, we've found the URL for the first sitemap listed in the robots.txt file. 
There may be many, although just the one is most common.

### Filtering directives for a user agent to a specific field type

Let's get all the `disallow` directives for Slurp:

```php
<?php
use webignition\RobotsTxt\File\Parser;
use webignition\RobotsTxt\Inspector\Inspector;

$parser = new Parser();
$parser->setSource(file_get_contents('http://example.com/robots.txt'));

$robotsTxtFile = $parser->getFile();

$inspector = new Inspector($robotsTxtFile);
$inspector->setUserAgent('slurp');

$slurpDisallowDirectiveList = $inspector->getDirectives()->getByField('disallow');
```

## Building

### Using as a library in a project
If used as a dependency by another project, update that project's composer.json
and update your dependencies.

    "require": {
        "webignition/robots-txt-file": "*"      
    }
    
This will get you the latest version. Check the [list of releases](https://github.com/webignition/robots-txt-file/releases) for specific versions.    

### Developing
This project has external dependencies managed with [composer][3]. Get and install this first.

    # Make a suitable project directory
    mkdir ~/robots-txt-file && cd ~/robots-txt-file

    # Clone repository
    git clone git@github.com:webignition/robots-txt-file.git.

    # Retrieve/update dependencies
    composer update
    
    # Run code sniffer and unit tests
    composer cs
    composer test

## Testing
Have look at the [project on travis][4] for the latest build status, or give the tests
a go yourself.

    cd ~/robots-txt-file
    composer test


[1]: http://www.robotstxt.org/
[2]: https://github.com/webignition/robots-txt-parser
[3]: http://getcomposer.org
[4]: http://travis-ci.org/webignition/robots-txt-file/builds

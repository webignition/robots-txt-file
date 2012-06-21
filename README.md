robots-txt-file [![Build Status](https://secure.travis-ci.org/webignition/robots-txt-file.png?branch=master)](http://travis-ci.org/webignition/robots-txt-file)
===============

Overview
---------
Models a [robots.txt][1] file. Can use be used to build a minimal (commentless)
robots.txt file programmatically. Use with [robots-txt-parser][2] to extract
details from live robots.txt files.

Using
-----



Building
--------

#### Using as a library in a project

If used as a dependency by another project, update that project's composer.json
and update your dependencies.

    "require": {
        "webignition/robots-txt-file": "*"      
    },
    "repositories": [
        {
            "type":"vcs",
            "url": "https://github.com/webignition/robots-txt-file"
        }
    ]

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
    phpunit tests


[1]: http://www.robotstxt.org/
[2]: https://github.com/webignition/robots-txt-parser
[3]: http://getcomposer.org
[4]: http://travis-ci.org/webignition/robots-txt-file/builds
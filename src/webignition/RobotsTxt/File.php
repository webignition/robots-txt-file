<?php
namespace webignition\RobotsTxt;

/**
 * Models a robots.txt file as derived from specifications at:
 * http://www.robotstxt.org/norobots-rfc.txt
 * http://www.robotstxt.org/orig.html
 * http://en.wikipedia.org/wiki/Robots_exclusion_standard
 * 
 * Short format description:
 * 
 * A robots txt file contains one or more _records_
 * 
 * A record starts with one or more _user_agent_strings_ followed
 * by one or more directives applying to matching user agents
 * 
 * A directive can be an Allow or Disallow instruction applying to
 * a specified user agent
 * 
 * A directive can be Sitemap instruction identifying a URL to an
 * XML sitemap. A Sitempa instruction applies to all user agents.
 * Many Sitemap instructions can be present.
 * 
 */
class File {

    
    
}
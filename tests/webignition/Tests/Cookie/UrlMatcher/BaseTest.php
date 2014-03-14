<?php

namespace webignition\Tests\Cookie\UrlMatcher;

use webignition\Cookie\UrlMatcher\UrlMatcher;

abstract class BaseTest extends \PHPUnit_Framework_TestCase {
    
    
    /**
     * 
     * @return \webignition\Cookie\UrlMatcher\UrlMatcher
     */
    protected function getUrlMatcher() {
        return new UrlMatcher();
    }
    
}
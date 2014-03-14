<?php

namespace webignition\Tests\Cookie\UrlMatcher;

class PathMatchOnlyTest extends BaseTest {
    
    public function testCookieWithNoPathTakesSlashOnlyPathOfRequestUrlAndMatches() { 
        $this->assertTrue($this->getUrlMatcher()->isMatch(array(            
            'domain' => '.example.com',
        ), 'http://example.com/'));
    }
    
    public function testCookieWithNoPathTakesFullPathOfRequestUrlUpToRightMostSlashAndMatches() {
        $this->assertTrue($this->getUrlMatcher()->isMatch(array(            
            'domain' => '.example.com',           
        ), 'http://example.com/foo/bar'));
    }
    
    public function testCookieWithMatchingPathMatches() {
        $this->assertTrue($this->getUrlMatcher()->isMatch(array(  
            'domain' => '.example.com',           
            'path' => '/foo'
        ), 'http://example.com/foo/bar'));
    }
    
}
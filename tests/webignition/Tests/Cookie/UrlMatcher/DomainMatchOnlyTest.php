<?php

namespace webignition\Tests\Cookie\UrlMatcher;

class DomainMatchTest extends BaseTest {
    
    public function testCookieWithExactMatchDomainMatches() { 
        $this->assertTrue($this->getUrlMatcher()->isMatch(array(            
            'domain' => 'example.com'
        ), 'http://example.com/'));
    }
    
    public function testCookieWithDotPrefixedButOtherwiseExactDomainMatches() {
        $this->assertTrue($this->getUrlMatcher()->isMatch(array(            
            'domain' => '.example.com'            
        ), 'http://example.com/'));
    }
    
    public function testCookieWithDotPrefixedDomainMatchesRequestUrlSubdomain() {
        $this->assertTrue($this->getUrlMatcher()->isMatch(array(  
            'domain' => '.example.com'  
        ), 'http://foo.example.com/'));
    }
    
}
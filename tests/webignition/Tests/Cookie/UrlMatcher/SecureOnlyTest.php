<?php

namespace webignition\Tests\Cookie\UrlMatcher;

class SecureOnlyTest extends BaseTest {
    
    public function testCookieWithNoSecureAttributeAndHttpRequestUrlSchemeMatches() { 
        $this->assertTrue($this->getUrlMatcher()->isMatch(array(
            'domain' => '.example.com',
        ), 'http://example.com/'));
    }
    
    public function testCookieSecureAttributeFalseAndHttpRequestUrlSchemeMatches() { 
        $this->assertTrue($this->getUrlMatcher()->isMatch(array(            
            'domain' => '.example.com',
            'secure' => false,
        ), 'http://example.com/'));
    }    
    
    public function testCookieSecureAttributeTrueAndHttpsRequestUrlSchemeMatches() { 
        $this->assertTrue($this->getUrlMatcher()->isMatch(array(            
            'domain' => '.example.com',
            'secure' => true,
        ), 'https://example.com/'));
    }     
    
    public function testCookieWithNoSecureAttributeAndHttpsRequestUrlSchemeMatches() { 
        $this->assertTrue($this->getUrlMatcher()->isMatch(array(            
            'domain' => '.example.com',
        ), 'https://example.com/'));
    }     

    public function testCookieSecureAttributeTrueAndHttpRequestUrlSchemeDoesNotMatch() { 
        $this->assertFalse($this->getUrlMatcher()->isMatch(array(            
            'domain' => '.example.com',
            'secure' => true,
        ), 'http://example.com/'));
    }         
    
    public function testCookieSecureAttributeFalseAndHttpsRequestUrlSchemeMatches() { 
        $this->assertTrue($this->getUrlMatcher()->isMatch(array(            
            'domain' => '.example.com',
            'secure' => false,
        ), 'https://example.com/'));
    }       
}
<?php

namespace webignition\Cookie\UrlMatcher;

/**
 * Cookie domain to URL matching. Determines if a given cookie should be
 * set for requests against a given URL.
 * 
 * Uses webignition/cookie-domain-matcher to implement domain-match checking 
 * rules defined in RFC6265: 
 * http://tools.ietf.org/html/rfc6265#section-5.1.3
 * 
 * Uses webignition/cookie-path-matcher to implement path-match checking 
 * rules defined in RFC6265: 
 * http://tools.ietf.org/html/rfc6265#section-5.1.4
 * 
 * Respects secure flag
 */
class UrlMatcher {
    
    /**
     *
     * @var array
     */
    private $cookie;
    
    
    /**
     *
     * @var \webignition\Url\Url
     */
    private $requestUrl;
    
    
    /**
     *
     * @var \webignition\Cookie\PathMatcher\PathMatcher
     */
    private $pathMatcher = null;
    
    
    /**
     *
     * @var \webignition\Cookie\DomainMatcher\DomainMatcher
     */
    private $domainMatcher = null;    
    
    
    public function isMatch($cookie, $requestUrl) {        
        $this->requestUrl = new \webignition\Url\Url($requestUrl);
        $this->setCookie($cookie);        
        
        if (!$this->getDomainMatcher()->isMatch($this->cookie['domain'], $this->requestUrl->getHost())) {
            return false;
        }
        
        if (!$this->getPathMatcher()->isMatch($this->cookie['path'], $this->requestUrl->getPath())) {
            return false;
        }
        
        if ($this->cookie['secure'] === true && $this->requestUrl->getScheme() != 'https') {
            return false;
        }        
        
        return true;
    }
    
    private function setCookie($cookie) {
        if (!isset($cookie['path'])) {
            $cookie['path'] = $this->deriveCookiePathFromRequestUrl();
        }
        
        if (!isset($cookie['domain'])) {
            $cookie['domain'] = '';
        }
        
        if (!isset($cookie['secure'])) {
            $cookie['secure'] = false;
        }
        
        $this->cookie = $cookie;
    }
    
    
    /**
     * Derive the path for a cookie from the request URL
     * 
     * As defined in RFC6265:
     *   2.  If the uri-path is empty or if the first character of the uri-
     *       path is not a %x2F ("/") character, output %x2F ("/") and skip
     *       the remaining steps.
     * 
     *   3.  If the uri-path contains no more than one %x2F ("/") character,
     *       output %x2F ("/") and skip the remaining step.
     * 
     *   4.  Output the characters of the uri-path from the first character up
     *       to, but not including, the right-most %x2F ("/").
     * 
     * @return string
     */
    private function deriveCookiePathFromRequestUrl() {
        $path = $this->requestUrl->getPath();

        if ($path->get() == '' || substr((string)$path, 0, 1) != '/') {
            return '/';
        }
        
        if (substr_count((string)$path, '/') === 1) {
            return '/';
        }
        
        return substr((string)$path, 0, strrpos((string)$path, '/'));
    }
    
    
    /**
     * 
     * @return \webignition\Cookie\PathMatcher\PathMatcher
     */
    private function getPathMatcher() {
        if (is_null($this->pathMatcher)) {
            $this->pathMatcher = new \webignition\Cookie\PathMatcher\PathMatcher();
        }
        
        return $this->pathMatcher;
    }
    
    
    /**
     * 
     * @return \webignition\Cookie\DomainMatcher\DomainMatcher
     */
    private function getDomainMatcher() {
        if (is_null($this->domainMatcher)) {
            $this->domainMatcher = new \webignition\Cookie\DomainMatcher\DomainMatcher();
        }
        
        return $this->domainMatcher;
    }
    
}
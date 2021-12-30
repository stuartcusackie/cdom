<?php

use stuartcusackie\cdom\cdom;

if (! function_exists('cdom')) {

    /**
     * Apply classes and attributes to content strings.
     * 
     * @param $markup string
     * @param $style string
     * @return string
     */
    function cdom($markup, $style = null) {
        $cdom = new cdom();
        return $cdom->transform($markup, $style);
    }
}

if (! function_exists('cdomel')) {

    /**
     * Return classes for a single element
     * and style
     * 
     * @param $el string
     * @param $style string
     * @return string
     */
    function cdomel($el, $style = null) {
        $cdom = new cdom();
        return $cdom->elClasses($el, $style);
    }
}


if (! function_exists('is_external_url')) {

    /**
     * Check whether a url is on the same base domain, or allow for subdomains
     * 
     * @param string $url
     * @return boolean
     */
    function is_external_url($url, $allowSubdomains = true) {

        $components = parse_url($url);

        // If we don't have a host (test.example.com) then it must be local
        if(empty($components['host'])) {
            return false;
        }

        if($allowSubdomains) {
            return get_domain_name($url) !== get_domain_name(url()->current());
        }
        else {
            return strcasecmp($components['host'], $request->getHttpHost());
        }
    }
}

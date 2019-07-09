<?php
if ( ! function_exists('sanitise')) {
    /**
     * @param string $input
     * @return string
     */
    function sanitise($input)
    {
        $clear = clean($input); // Package to remove code "mews/purifier"
        $clear = strip_tags($clear);
        $clear = html_entity_decode($clear);
        $clear = urldecode($clear);
        $clear = preg_replace('~[\r\n\t]+~', ' ', trim($clear));
        $clear = preg_replace('/ +/', ' ', $clear);
        return $clear;
    }

    /**
     * @param string $input
     * @return string
     */
    function clean_whitespace($input)
    {
        $clear = preg_replace('~[\r\n\t]+~', ' ', trim($input));
        $clear = preg_replace('/ +/', ' ', $clear);
        return $clear;
    }
}

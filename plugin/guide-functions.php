<?php
/**
 * Plugin Name: Guide Functions
 * Plugin URI: http://fbtb.net
 * Description: In an effort to not make some terrible PHP code, this is a file that supports a whole lot of the custom functions we use for the Set Guide
 * Author: Nick Martin
 * Author URI: http://dWhisper.com
 * Version: 0.1.0
 */

/* Place custom code below this line. */

include_once('config.inc.php');

function guide_get_set_by_number( $number ) {
    
}

function guide_get_set_by_stub( $stub ) {
    $query = "select * from `".DB_PREFIX."_guide` WHERE stub='".$stub;
}

function get_minifgs_for_set


function sluggify( $url ) {
    # Prep string with some basic normalization
    $url = strtolower($url);
    $url = strip_tags($url);
    $url = stripslashes($url);
    $url = html_entity_decode($url);
    # Remove quotes (can't, etc.)
    $url = str_replace('\'', '', $url);
    # Replace non-alpha numeric with hyphens
    $match = '/[^a-z0-9]+/';
    $replace = '-';
    $url = preg_replace($match, $replace, $url);
    $url = trim($url, '-');
    return $url;
}



/* Place custom code above this line. */
?>
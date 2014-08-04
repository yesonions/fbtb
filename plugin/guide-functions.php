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

//include_once('config.inc.php');
defined('ABSPATH') or die("Bad fish!");

const DB_PREFIX = "test_";

function guide_get_themes() {
    global $wpdb;
    
    $query = "select * from `".DB_PREFIX."guide_theme` WHERE parent is NULL";
    $results = $wpdb->get_results($query);
    return $results;
    //return "What the hell, man";
}
   
function guide_get_set_by_number( $number ) {

}

function guide_get_set_by_stub( $stub ) {
    $query = "select * from `".DB_PREFIX."guide` WHERE stub='".$stub;
}

function guide_get_minifgs_for_set( $id ) {

}

function guide_get_affiliates_for_set( $id ) {

}

function guide_get_prices_for_set( $id ) {

}

function guide_get_reviews_for_set( $id ) {

}

function guide_get_subthemes_for_theme( $theme ) {
    global $wpdb;
    $query = "select * from `".DB_PREFIX."guide_theme` where parent ='".$theme."'";
    $subthemes = $wpdb->get_results($query);
    return $subthemes;
    //return $query;
}

function guide_get_theme_years( $theme ) {
    $years = $wpdb->get_results("select count(*) as totals, date_released as year from `".DB_PREFIX."_guide` where theme =".$theme." group by released order by released desc");
}

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
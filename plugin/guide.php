<?php
/*
Template Name: FBTB Guide - Main
*/
    defined('ABSPATH') or die("Bad fish!");
	global $wpdb;
	$query = "";
	get_header(); 
?>
<link rel="stylesheet" href="/styles/flags.css" type="text/css" />
<link rel="stylesheet" href="/styles/guide.css" type="text/css" />
<div id="content" class="container narrowcolumn">
    
<?php
    //If the user is an admin, show the admin panel
    if (is_user_logged_in() && current_user_can('publish_posts')) {
?>
    <div>
        <ul class="nav">
            <li><a href="/guide/edit/?type=set"><span class="icon-plus-sign"></span>Add a new Set</a></li>
            <li><a href="/guide/edit/?type=minifig">Add Minifigs</a></li>
            <li><a href="/guide/admin/?action=reviewers">Manage Reviewers</a></li>            
            <li><a href="/guide/admin/?action=affiliates">Manage Affiliates</a></li>
            <li><a href="/guide/admin/?action=countries">Manage Countries</a></li>
        </ul>
    </div> 
<?php
} //End Admin Section

//Only Load if the Page is Valid
if (is_page() ) {
    $theme = $_GET['theme'];
    $subtheme = $_GET['subtheme'];
    $year = $_GET['year'];
}
?>
    
<?php 
}
?>
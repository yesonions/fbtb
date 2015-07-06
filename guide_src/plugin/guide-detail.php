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
} //End Admin Section

//Only Load if the Page is Valid
if (is_page() ) {
    $stub = $_GET['stub'];
    
    $set = guide_get_set_by_stub($stub);

?>
    
<?php
    //If the user is an admin, show the admin panel
    if (is_user_logged_in() && current_user_can('publish_posts')) {
?>
    <div>
        <ul class="nav">
            <li><a href="/guide/edit/?id=<?php echo $id ?>" class="edit-set"><span class="icon-plus-sign"></span>Edit Set</a></li>
            <li><a href="#" class="add-minifig">Minifigs</a></li>
            <li><a href="#">Sales</a></li>            
            <li><a href="#">Reviews</a></li>
            <li><a href="#" class="add-price">Prices</a></li>
        </ul>
    </div> 

    
<?php 
     } //End the Admin Section
?>
    
<?php
} //End the Big Loop
?>
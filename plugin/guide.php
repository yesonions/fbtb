<?php
/*
Template Name: FBTB Guide - Main
*/
    defined('ABSPATH') or die("Bad fish!");
	global $wpdb;
	$query = "";
	get_header(); 

    //include_once('guide-functions.php');
?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">



<link rel="stylesheet" href="/styles/flags.css" type="text/css" />
<link rel="stylesheet" href="/styles/guide.css" type="text/css" />
<div id="content" class="narrowcolumn">
<div class="container">
    
<?php
    //If the user is an admin, show the admin panel
    if (is_user_logged_in() && current_user_can('publish_posts')) {
?>
    <div>
        <ul class="nav nav-pills">
            <li><a href="/guide/edit/?type=set"><span class="icon-plus-sign"></span>Add a new Set</a></li>
            <li><a href="/guide/edit/?type=minifig">Add Minifigs</a></li>
            <li><a href="/guide/admin/?action=reviewers">Manage Reviewers</a></li>            
            <li><a href="/guide/admin/?action=affiliates">Manage Affiliates</a></li>
            <li><a href="/guide/admin/?action=countries">Manage Countries</a></li>
        </ul>
    </div> 
<?php
} //End Admin Section

if (is_page() ) { //Only Load if the Page is Valid
    //echo "hey buddy";
    $themeid = $_GET['theme'];
    $subthemeid = $_GET['subtheme'];
    $year = $_GET['year'];
    
    if ($themeid == null && $subthemeid == null && $year == null) {	//Default Page, Load Everything
        //$themes = $guideAPI->guide_get_themes();
        //$themes = guide_get_themes();
        if(function_exists('guide_get_themes')) {
            echo "It knows the function exists";
            $themes = guide_get_themes();
        }
        else {
            echo "Screw You, Billy";
        }
        
        foreach($themes as $theme) {
    ?>
        <div class="row guide">
            <div class="col-md-3">
                <h4><?php echo $theme->name; ?></h4>
                <img src="<?php echo $theme->image; ?>" alt="<?php $theme->name; ?>" />
            </div>
            <div class="col-md-9">
                <!-- Set up the Subthemes -->
                <div class="row">
                <?php 
                    $subthemes = guide_get_subthemes_for_theme($theme->id);
                    echo $subthemes;
                    foreach($subthemes as $subtheme) {
                ?>
                    <div class="col-md-3">
                        <h4><?php echo $subtheme->name ?></h4>
                        <img src="<?php echo $subtheme->image; ?>" alt="<?php $subtheme->name; ?>" class="image-responsive" />
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    <?php 
        }
    }
}
?>
</div>
</div>
<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
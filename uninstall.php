<?php

if(!defined('WP_UNINSTALL_PLUGIN')){
    die;
}

//Delete post type from db

// global $wpdb;

// $wpdb -> query("DELETE FROM {$wpdb->posts} WHERE post_type IN ('amosearch');");


//remove meta

//remove tax/terms

//remove comments

$rooms = get_posts(array('post_type' => 'product', 'numberposts' => -1));

foreach($rooms as $roo)
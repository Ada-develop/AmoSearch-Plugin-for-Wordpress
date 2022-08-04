<?php 

/*
Plugin Name: AmoSearch
Plugin URI: http://amosearch.com/
Description: AmoSearch - Lightining fast AJAX products search on website.
Author: AmoSearch MB
Version: 1.0
License: GPLv2 or later
Author URI: http://amosearch.com/
Text Domain: amosearch
*/

error_reporting(0);

if(!function_exists('add_action'))
{
  die;
}

class AmoSearch
{
  // Methods
  

  public function __construct()
  {
    
    add_action('init',[$this,'custom_post_type']);
    add_action('init','XMLFileCreation');
    add_action('init','SearchBarResult');
     
  }


}



function XMLFileCreation(){
  $cache = dirname(__FILE__)."/products.txt";

  if(file_exists($cache))
  {
    echo null;
  }
  else
  {
      $output = NULL; 
  global $wpdb;

 $query = $wpdb->get_results("SELECT wp_posts.ID , wp_posts.guid, wp_posts.post_title,wp_wc_product_meta_lookup.min_price, wp_posts.post_parent, wp_wc_product_meta_lookup.product_id FROM wp_posts INNER JOIN wp_wc_product_meta_lookup ON wp_posts.ID=wp_wc_product_meta_lookup.product_id  WHERE post_type LIKE 'product%'", ARRAY_A);

 //  XML Parser / Cacheing
echo(dirname(__FILE__)."products.txt");
$JSONfile = fopen((dirname(__FILE__)."/products.txt"), 'a') or die ('error writing');


if ($wpdb->num_rows > 0) {
// output data of each row
foreach($query as $row){
  $title =  preg_replace('/"/','\"',$row["post_title"])  ;

$JSONoutput .= '{"product" : {
 "id" : "' . $row["ID"]. '",
 "link" : "' . $row["guid"]. '",
 "title" : "' . $title . '",
 "price" : "' . $row["min_price"]. '",
 "photoLink" : "' . $row["post_parent"].'"}} |';

}
fwrite($JSONfile, $JSONoutput);

fclose($JSONfile);

}}}





if(class_exists(('AmoSearch'))){
  new AmoSearch();
  
  
  }


function amosearch_searchbar(){
  echo include 'livesearch.php';
}


add_shortcode('amosearchbar', 'amosearch_searchbar');
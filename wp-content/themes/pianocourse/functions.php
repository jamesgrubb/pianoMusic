<?php

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'your-theme', TEMPLATEPATH . '/languages' );
 
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);
 
// Get the page number
function get_page_number() {
    if ( get_query_var('paged') ) {
        print ' | ' . __( 'Page ' , 'your-theme') . get_query_var('paged');
    }
} // end get_page_number

add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}

add_theme_support( 'menus' );




// add category nicenames in body and post class
	function category_id_class($classes) {
	    global $post;
	    foreach((get_the_category($post->ID)) as $category)
	        $classes[] = $category->category_nicename;
	        return $classes;
	}
	add_filter('post_class', 'category_id_class');
	add_filter('body_class', 'category_id_class');


if( !is_admin()){
   wp_deregister_script('jquery'); 
   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"), false, '1.3.2'); 
   wp_enqueue_script('jquery');
}


?>
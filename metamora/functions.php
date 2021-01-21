<?php

register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'metamora-theme' ),
	'secondary' => __('Secondary Menu', 'metamora-theme'),
	'footer' => __('Footer Menu', 'metamora-theme'),
	'legalfooter' => __('Legal Menu', 'metamora-theme'),
	'banking' => __('Banking Menu', 'metamora-theme'),
	'loans' => __('Loans Menu', 'metamora-theme'),
	'community' => __('Community Menu', 'metamora-theme'),
	'about' => __('About Menu', 'metamora-theme'),

) );
	
// Register Custom Navigation Walker
require_once('wp-bootstrap-navwalker.php');	

	// Add RSS links to <head> section
	automatic_feed_links();
	
	// Load jQuery
	if ( !is_admin() ) {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"), false);
	   wp_enqueue_script('jquery');
	}
	
	// Load jQuery
	if ( !is_admin() ) {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"), false);
	   wp_enqueue_script('jquery');
	}
	
	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
	// Declare sidebar widget zone
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Sidebar Widgets',
    		'id'   => 'sidebar-widgets',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h2>',
    		'after_title'   => '</h2>'
    	));
    }
	
	function new_excerpt_more($more) {
	global $post;
	return '... <a href="'. get_permalink($post->ID) . '">Read more</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

function custom_excerpt_length( $length ) {
	return 50;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
add_theme_support( 'post-thumbnails', array( 'post' ) );          // Posts only

?>
<?php

/* 
Register CSS file
*/

function lms_scripts(){
	wp_register_style('style-theme', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('style-theme');
}

add_action('wp_enqueue_scripts', 'lms_scripts' );


/* Register custom post type for 'Courses' */


/**
 * Register a custom post type called "book".
 *
 * @see get_post_type_labels() for label keys.
 */
function cpt_courses() {
	$labels = array(
		'name'                  => _x( 'Courses', 'Post type general name', 'courses' ),
		'singular_name'         => _x( 'Course', 'Post type singular name', 'courses' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'courses' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
	);

	register_post_type( 'courses', $args );
}

add_action( 'init', 'cpt_courses' );


?>
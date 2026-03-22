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
	);

	register_post_type( 'courses', $args );
}

add_action( 'init', 'cpt_courses' );


/* Adding custom fields for courses */

function cf_courses(){
	add_meta_box(
		'cf_courses_id', 			// unique custom field id
		'Course Details', 			// custom fields name
		'cf_courses_function',		// functions that will hold the CF content
		'courses',					// cpt associated with this custom field
		'normal',					// the position of the cf in the dashboard
	);
}

add_action('admin_init','cf_courses');

function cf_courses_function(){
	?>
	
	<p class="cf-title">Subtitle</p>
	<textarea type="text" class="cf-text" name="db_subtitle"></textarea>
	
	<p class="cf-title">Trailer URL</p>
	<textarea type="text" class="cf-text" name="db_trailer"></textarea>
	
	
	<style type="text/css">
		.cf-title{text-align: center;}
		.cf-text{width:100%;}
	</style>
	
	
	<?php
	
}

/* Create database table - course details */

function db_course_details(){
	global $wpdb;
	$charset 	= $wpdb->get_charset_collate();
	
	$db_content = "CREATE TABLE $table_name(
		course_id	BIGINT(20) NOT NULL,
		subtitle	TEXT NOT NULL,
		trailer 	TEXT NOT NULL,
		
		PRIMARY KEY (course_id)
	) $charset; ";
	
	require_once( ABSPATH.'wp-admin/includes/upgrade.php');
	
	dbDelta($db_content);
}

add_action('init', 'db_course_details');

/* saving data to database */

function save_data($post_data){
	global $wpdb;
	$course_id = get_the_id();

	if (isset($_POST['db_subtitle']) && isset($_POST['db_trailer'])) {

	$subtitle 	= $_POST['db_subtitle'];
	$trailer 	= $_POST['db_trailer'];

	}

	$table_name = $wpdb->prefix . "course_details";

	$table_name = $wpdb->prefix . "course_details";

	$wpdb->replace(
		$table_name,
		[
			'course_id' => $course_id,
			'subtitle' => $subtitle,
			'trailer' => $trailer
		]
	);
}

add_action('save_post', 'save_data');


?>
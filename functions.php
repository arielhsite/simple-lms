<?php

/* 
Register CSS file
*/

function lms_scripts(){
	wp_register_style('style-theme', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('style-theme');
}

add_action('wp_enqueue_scripts', 'lms_scripts' );

?>
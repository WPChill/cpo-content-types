<?php

//Define testimonials post type
add_action('init', 'ctct_cpost_testimonials');
function ctct_cpost_testimonials(){
	$show_ui = false;
	if(defined('CPOTHEME_USE_TESTIMONIALS') || ctct_get_option('display_testimonials')){
		$show_ui = true;
	}
	
	//Set up labels
	$labels = array('name' => __('Testimonials', 'ctct'),
	'singular_name' => __('Testimonial', 'ctct'),
	'add_new' => __('Add Testimonial', 'ctct'),
	'add_new_item' => __('Add New Testimonial', 'ctct'),
	'edit_item' => __('Edit Testimonial', 'ctct'),
	'new_item' => __('New Testimonial', 'ctct'),
	'view_item' => __('View Testimonial', 'ctct'),
	'search_items' => __('Search Testimonials', 'ctct'),
	'not_found' =>  __('No testimonials found.', 'ctct'),
	'not_found_in_trash' => __('No testimonials found in the trash.', 'ctct'), 
	'parent_item_colon' => '');
	
	$fields = array('labels' => $labels,
	'public' => false,
	'publicly_queryable' => false,
	'show_ui' => $show_ui, 
	'query_var' => true,
	'rewrite' => true,
	'capability_type' => 'page',
	'hierarchical' => false,
	'menu_icon' => 'dashicons-format-chat',
	'menu_position' => null,
	'supports' => array('title', 'editor', 'thumbnail', 'page-attributes')); 
	
	register_post_type('cpo_testimonial', $fields);
}

//Define admin columns in testimonials post type	
add_filter('manage_edit-cpo_testimonial_columns', 'ctct_cpost_testimonials_columns');
if(!function_exists('ctct_cpost_testimonials_columns')){
	function ctct_cpost_testimonials_columns($columns){
		$columns = array(
		'cb' => '<input type="checkbox" />',
		'ctct-image' => __('Image', 'ctct'),
		'title' => __('Title', 'ctct'),
		'date' => __('Date', 'ctct'),
		'author' => __('Author', 'ctct'),
		);
		return $columns;
	}
}
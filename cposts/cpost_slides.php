<?php

//Define slides post type
add_action('init', 'ctct_cpost_slides');
function ctct_cpost_slides(){
	$show_ui = false;
	if(defined('CPOTHEME_USE_SLIDES') || ctct_get_option('display_slides')){
		$show_ui = true;
	}
	
	//Set up labels
	$labels = array('name' => __('Slides', 'ctct'),
	'singular_name' => __('Slide', 'ctct'),
	'add_new' => __('New Slide', 'ctct'),
	'add_new_item' => __('Add New Slide', 'ctct'),
	'edit_item' => __('Edit Slide', 'ctct'),
	'new_item' => __('New Slide', 'ctct'),
	'view_item' => __('View Slide', 'ctct'),
	'search_items' => __('Search Slides', 'ctct'),
	'not_found' =>  __('No slides were found.', 'ctct'),
	'not_found_in_trash' => __('No slides were found in the trash.', 'ctct'), 
	'parent_item_colon' => '');
	
	$fields = array('labels' => $labels,
	'public' => false,
	'publicly_queryable' => false,
	'show_ui' => $show_ui, 
	'query_var' => true,
	'rewrite' => true,
	'capability_type' => 'page',
	'hierarchical' => false,
	'menu_icon' => 'dashicons-images-alt2',
	'menu_position' => null,
	'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes')); 
	
	register_post_type('cpo_slide', $fields);
}

//Define admin columns in slides post type	
add_filter('manage_edit-cpo_slide_columns', 'ctct_cpost_slides_columns');
if(!function_exists('ctct_cpost_slides_columns')){
	function ctct_cpost_slides_columns($columns){
		$columns = array(
		'cb' => '<input type="checkbox" />',
		'ctct-image' => __('Image', 'ctct'),
		'title' => __('Title', 'ctct'),
		'date' => __('Date', 'ctct'),
		'comments' => '<span class="vers"><span title="'.__('Comments', 'ctct').'" class="comment-grey-bubble"></span></span>',
		'author' => __('Author', 'ctct'),
		);
		return $columns;
	}
}
	
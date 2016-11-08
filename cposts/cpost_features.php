<?php

//Define features post type
add_action('init', 'ctct_cpost_features');
function ctct_cpost_features(){
	$show_ui = false;
	if(defined('CPOTHEME_USE_FEATURES') || ctct_get_option('display_features')){
		$show_ui = true;
	}
	
	//Set up labels
	$labels = array('name' => __('Features', 'ctct'),
	'singular_name' => __('Feature', 'ctct'),
	'add_new' => __('Add Feature', 'ctct'),
	'add_new_item' => __('Add New Feature', 'ctct'),
	'edit_item' => __('Edit Feature', 'ctct'),
	'new_item' => __('New Feature', 'ctct'),
	'view_item' => __('View Features', 'ctct'),
	'search_items' => __('Search Features', 'ctct'),
	'not_found' =>  __('No features found.', 'ctct'),
	'not_found_in_trash' => __('No features found in the trash.', 'ctct'), 
	'parent_item_colon' => '');
	
	$fields = array('labels' => $labels,
	'public' => false,
	'publicly_queryable' => false,
	'show_ui' => $show_ui, 
	'query_var' => true,
	'rewrite' => true,
	'capability_type' => 'page',
	'hierarchical' => false,
	'menu_icon' => 'dashicons-star-filled',
	'menu_position' => null,
	'supports' => array('title', 'editor', 'thumbnail', 'page-attributes')); 
	
	register_post_type('cpo_feature', $fields);
}


//Define admin columns in features post type	
add_filter('manage_edit-cpo_feature_columns', 'ctct_cpost_features_columns');
if(!function_exists('ctct_cpost_features_columns')){
	function ctct_cpost_features_columns($columns){
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
	
<?php

//Define clients post type
add_action('init', 'ctct_cpost_clients');
function ctct_cpost_clients(){
	$show_ui = false;
	if(defined('CPOTHEME_USE_CLIENTS') || ctct_get_option('display_clients')){
		$show_ui = true;
	}
	
	//Set up labels
	$labels = array('name' => __('Clients', 'ctct'),
	'singular_name' => __('Client', 'ctct'),
	'add_new' => __('Add Client', 'ctct'),
	'add_new_item' => __('Add New Client', 'ctct'),
	'edit_item' => __('Edit Client', 'ctct'),
	'new_item' => __('New Client', 'ctct'),
	'view_item' => __('View Client', 'ctct'),
	'search_items' => __('Search Clients', 'ctct'),
	'not_found' =>  __('No clients found.', 'ctct'),
	'not_found_in_trash' => __('No clients found in the trash.', 'ctct'), 
	'parent_item_colon' => '');
	
	$fields = array('labels' => $labels,
	'public' => false,
	'publicly_queryable' => false,
	'show_ui' => $show_ui, 
	'query_var' => true,
	'rewrite' => true,
	'capability_type' => 'page',
	'hierarchical' => false,
	'menu_icon' => 'dashicons-businessman',
	'menu_position' => null,
	'supports' => array('title', 'excerpt', 'thumbnail', 'page-attributes')); 
	
	register_post_type('cpo_client', $fields);
}


//Define admin columns in clients post type	
add_filter('manage_edit-cpo_client_columns', 'ctct_cpost_clients_columns');
if(!function_exists('ctct_cpost_clients_columns')){
	function ctct_cpost_clients_columns($columns){
		$columns = array(
		'cb' => '<input type="checkbox" />',
		'cpo-image' => __('Image', 'ctct'),
		'title' => __('Title', 'ctct'),
		'date' => __('Date', 'ctct'),
		'author' => __('Author', 'ctct'),
		);
		return $columns;
	}
}
<?php

//Define services post type
add_action('init', 'ctct_cpost_services');
function ctct_cpost_services(){
	$show_ui = false;
	if(defined('CPOTHEME_USE_SERVICES') || ctct_get_option('display_services')){
		$show_ui = true;
	}
	
	//Set up labels
	$labels = array('name' => __('Services', 'ctct'),
	'singular_name' => __('Services', 'ctct'),
	'add_new' => __('Add Service', 'ctct'),
	'add_new_item' => __('Add New Service', 'ctct'),
	'edit_item' => __('Edit Service', 'ctct'),
	'new_item' => __('New Service', 'ctct'),
	'view_item' => __('View Service', 'ctct'),
	'search_items' => __('Search Services', 'ctct'),
	'not_found' =>  __('No services found.', 'ctct'),
	'not_found_in_trash' => __('No services found in the trash.', 'ctct'), 
	'parent_item_colon' => '');
	
	$slug = ctct_get_option('slug_service');
	if($slug == '') $slug = 'service';
	$fields = array('labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => $show_ui, 
	'query_var' => true,
	'rewrite' => array('slug' => apply_filters('cpotheme_slug_service', $slug)),
	'capability_type' => 'page',
	'hierarchical' => false,
	'menu_icon' => 'dashicons-archive',
	'menu_position' => null,
	'show_in_nav_menus' => true,
	'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes')); 
	
	register_post_type('cpo_service', $fields);
}


//Define admin columns in services post type
add_filter('manage_edit-cpo_service_columns', 'ctct_cpost_services_columns');	
if(!function_exists('ctct_cpost_services_columns')){
	function ctct_cpost_services_columns($columns){
		$columns = array(
		'cb' => '<input type="checkbox" />',
		'cpo-image' => __('Image', 'ctct'),
		'title' => __('Title', 'ctct'),
		'cpo-service-cats' => __('Categories', 'ctct'),
		'cpo-service-tags' => __('Tags', 'ctct'),
		'date' => __('Date', 'ctct'),
		'comments' => '<span class="vers"><span title="'.__('Comments', 'ctct').'" class="comment-grey-bubble"></span></span>',
		'author' => __('Author', 'ctct'),
		);
		return $columns;
	}
}
	
//Define services category taxonomy
add_action('init', 'ctct_tax_servicescategory');
if(!function_exists('ctct_tax_servicescategory')){
	function ctct_tax_servicescategory() 
	{
		$labels = array('name' => __('Service Categories', 'ctct'),
		'singular_name' => __('Service Category', 'ctct'),
		'add_new' => __('New Service Category', 'ctct'),
		'add_new_item' => __('Add Service Category', 'ctct'),
		'edit_item' => __('Edit Service Category', 'ctct'),
		'new_item' => __('New Service Category', 'ctct'),
		'view_item' => __('View Service Category', 'ctct'),
		'search_items' => __('Search Service Categories', 'ctct'),
		'not_found' =>  __('No services categories were found.', 'ctct'),
		'not_found_in_trash' => __('No services categories were found in the trash.', 'ctct'), 
		'parent_item_colon' => '');
		
		$slug = ctct_get_option('slug_service_category');
		if($slug == '') $slug = 'service-category';
		$fields = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'rewrite' => array('slug' => apply_filters('cpotheme_slug_service_category', $slug)),
		'hierarchical' => true); 
		
		register_taxonomy('cpo_service_category', 'cpo_service', $fields);
	}
}
	
//Define services tag taxonomy
add_action('init', 'ctct_tax_servicestag');
if(!function_exists('ctct_tax_servicestag')){
	function ctct_tax_servicestag() 
	{
		//Set up labels
		$labels = array('name' => __('Service Tags', 'ctct'),
		'singular_name' => __('Service Tag', 'ctct'),
		'add_new' => __('New Service Tag', 'ctct'),
		'add_new_item' => __('Add Service Tag', 'ctct'),
		'edit_item' => __('Edit Service Tag', 'ctct'),
		'new_item' => __('New Service Tag', 'ctct'),
		'view_item' => __('View Service Tag', 'ctct'),
		'search_items' => __('Search Service Tags', 'ctct'),
		'not_found' =>  __('No services tags were found.', 'ctct'),
		'not_found_in_trash' => __('No services tags were found in the trash.', 'ctct'), 
		'parent_item_colon' => '');
		
		$slug = ctct_get_option('slug_service_tag');
		if($slug == '') $slug = 'service-tag';
		$fields = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'rewrite' => array('slug' => apply_filters('cpotheme_slug_service_tag', $slug)),
		'hierarchical' => false); 
		
		register_taxonomy('cpo_service_tag', 'cpo_service', $fields);
	}
}
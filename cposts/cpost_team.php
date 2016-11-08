<?php

//Define team post type
add_action('init', 'ctct_cpost_team');
function ctct_cpost_team(){
	$show_ui = false;
	if(defined('CPOTHEME_USE_TEAM') || ctct_get_option('display_team')){
		$show_ui = true;
	}
	$labels = array('name' => __('Team Members', 'ctct'),
	'singular_name' => __('Team Member', 'ctct'),
	'add_new' => __('Add Team Member', 'ctct'),
	'add_new_item' => __('Add New Team Member', 'ctct'),
	'edit_item' => __('Edit Team Member', 'ctct'),
	'new_item' => __('New Team Member', 'ctct'),
	'view_item' => __('View Team Member', 'ctct'),
	'search_items' => __('Search Team Members', 'ctct'),
	'not_found' =>  __('No team members found.', 'ctct'),
	'not_found_in_trash' => __('No team members found in the trash.', 'ctct'), 
	'parent_item_colon' => '');
	
	$fields = array('labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'exclude_from_search' => true,
	'show_ui' => $show_ui, 
	'query_var' => true,
	'rewrite' => true,
	'capability_type' => 'page',
	'hierarchical' => false,
	'menu_icon' => 'dashicons-universal-access',
	'menu_position' => null,
	'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes')); 
	
	register_post_type('cpo_team', $fields);
}


//Define admin columns in team post type
add_filter('manage_edit-cpo_team_columns', 'ctct_cpost_team_columns');
if(!function_exists('ctct_cpost_team_columns')){
	function ctct_cpost_team_columns($columns){
		$columns = array(
		'cb' => '<input type="checkbox" />',
		'ctct-image' => __('Image', 'ctct'),
		'title' => __('Title', 'ctct'),
		'ctct-team-cats' => __('Groups', 'ctct'),
		'date' => __('Date', 'ctct'),
		'author' => __('Author', 'ctct'),
		);
		return $columns;
	}
}
	
//Define team category taxonomy
add_action('init', 'ctct_tax_teamcategory');
if(!function_exists('ctct_tax_teamcategory')){
	function ctct_tax_teamcategory() 
	{
		$labels = array('name' => __('Member Groups', 'ctct'),
		'singular_name' => __('Member Group', 'ctct'),
		'add_new' => __('New Member Group', 'ctct'),
		'add_new_item' => __('Add Member Group', 'ctct'),
		'edit_item' => __('Edit Member Group', 'ctct'),
		'new_item' => __('New Member Group', 'ctct'),
		'view_item' => __('View Member Group', 'ctct'),
		'search_items' => __('Search Member Groups', 'ctct'),
		'not_found' =>  __('No member groups were found.', 'ctct'),
		'not_found_in_trash' => __('No member groups were found in the trash.', 'ctct'), 
		'parent_item_colon' => '');
		
		$slug = ctct_get_option('slug_team_category');
		if($slug == '') $slug = 'team-group';
		$fields = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => false,
		'rewrite' => array('slug' => apply_filters('cpotheme_slug_team_category', $slug)),
		'hierarchical' => true); 
		
		register_taxonomy('cpo_team_category', 'cpo_team', $fields);
	}
}
<?php

//Define portfolio post type
add_action('init', 'ctct_cpost_portfolio');
function ctct_cpost_portfolio(){
	$show_ui = false;
	if(defined('CPOTHEME_USE_PORTFOLIO') || ctct_get_option('display_portfolio')){
		$show_ui = true;
	}
	
	//Set up labels
	$labels = array('name' => __('Portfolio', 'ctct'),
	'singular_name' => __('Portfolio', 'ctct'),
	'add_new' => __('Add Portfolio Item', 'ctct'),
	'add_new_item' => __('Add New Portfolio Item', 'ctct'),
	'edit_item' => __('Edit Portfolio Item', 'ctct'),
	'new_item' => __('New Portfolio Item', 'ctct'),
	'view_item' => __('View Portfolio', 'ctct'),
	'search_items' => __('Search Portfolio', 'ctct'),
	'not_found' =>  __('No portfolio items found.', 'ctct'),
	'not_found_in_trash' => __('No portfolio items found in the trash.', 'ctct'), 
	'parent_item_colon' => '');
	
	$slug = ctct_get_option('slug_portfolio');
	if($slug == '') $slug = 'portfolio-item';
	$fields = array('labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => $show_ui, 
	'query_var' => true,
	'rewrite' => array('slug' => apply_filters('cpotheme_slug_portfolio', $slug)),
	'capability_type' => 'page',
	'hierarchical' => false,
	'menu_icon' => 'dashicons-portfolio',
	'show_in_nav_menus' => true,
	'menu_position' => null,
	'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'comments')); 
	
	register_post_type('cpo_portfolio', $fields);
}


//Define admin columns in portfolio post type	
add_filter('manage_edit-cpo_portfolio_columns', 'ctct_cpost_portfolio_columns');
if(!function_exists('ctct_cpost_portfolio_columns')){
	function ctct_cpost_portfolio_columns($columns){
		$columns = array(
		'cb' => '<input type="checkbox" />',
		'ctct-image' => __('Image', 'ctct'),
		'title' => __('Title', 'ctct'),
		'ctct-portfolio-cats' => __('Categories', 'ctct'),
		'ctct-portfolio-tags' => __('Tags', 'ctct'),
		'date' => __('Date', 'ctct'),
		'comments' => '<span class="vers"><span title="'.__('Comments', 'ctct').'" class="comment-grey-bubble"></span></span>',
		'author' => __('Author', 'ctct'),
		);
		return $columns;
	}
}
	
//Define portfolio category taxonomy
add_action('init', 'ctct_tax_portfoliocategory');
if(!function_exists('ctct_tax_portfoliocategory')){
	function ctct_tax_portfoliocategory() 
	{
		$labels = array('name' => __('Portfolio Categories', 'ctct'),
		'singular_name' => __('Portfolio Category', 'ctct'),
		'add_new' => __('New Portfolio Category', 'ctct'),
		'add_new_item' => __('Add Portfolio Category', 'ctct'),
		'edit_item' => __('Edit Portfolio Category', 'ctct'),
		'new_item' => __('New Portfolio Category', 'ctct'),
		'view_item' => __('View Portfolio Category', 'ctct'),
		'search_items' => __('Search Portfolio Categories', 'ctct'),
		'not_found' =>  __('No portfolio categories were found.', 'ctct'),
		'not_found_in_trash' => __('No portfolio categories were found in the trash.', 'ctct'), 
		'parent_item_colon' => '');
		
		$slug = ctct_get_option('slug_portfolio_category');
		if($slug == '') $slug = 'portfolio-category';
		$fields = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'rewrite' => array('slug' => apply_filters('cpotheme_slug_portfolio_category', $slug)),
		'hierarchical' => true); 
		
		register_taxonomy('cpo_portfolio_category', 'cpo_portfolio', $fields);
	}
}
	
//Define portfolio tag taxonomy
add_action('init', 'ctct_tax_portfoliotag');
if(!function_exists('ctct_tax_portfoliotag')){
	function ctct_tax_portfoliotag() 
	{
		//Set up labels
		$labels = array('name' => __('Portfolio Tags', 'ctct'),
		'singular_name' => __('Portfolio Tag', 'ctct'),
		'add_new' => __('New Portfolio Tag', 'ctct'),
		'add_new_item' => __('Add Portfolio Tag', 'ctct'),
		'edit_item' => __('Edit Portfolio Tag', 'ctct'),
		'new_item' => __('New Portfolio Tag', 'ctct'),
		'view_item' => __('View Portfolio Tag', 'ctct'),
		'search_items' => __('Search Portfolio Tags', 'ctct'),
		'not_found' =>  __('No portfolio tags were found.', 'ctct'),
		'not_found_in_trash' => __('No portfolio tags were found in the trash.', 'ctct'), 
		'parent_item_colon' => '');
		
		$slug = ctct_get_option('slug_portfolio_tag');
		if($slug == '') $slug = 'portfolio-tag';
		$fields = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'rewrite' => array('slug' => apply_filters('cpotheme_slug_portfolio_tag', $slug)),
		'hierarchical' => false); 
		
		register_taxonomy('cpo_portfolio_tag', 'cpo_portfolio', $fields);
	}
}

//Modify main query on portfolio categories and tags, to change number of posts equal to number of columns
add_action('pre_get_posts', 'ctct_tax_portfolio_query');
if(!function_exists('ctct_tax_portfolio_query')){
	function ctct_tax_portfolio_query($query){
		if((is_tax('cpo_portfolio_category') && is_tax('cpo_portfolio_tag')) && $query->is_main_query() && !is_admin()){
			$columns = ctct_get_option('portfolio_columns');
			if($columns != '' && $columns > 0){
				$post_number = ctct_get_option('portfolio_columns') * 4;
				$query->set('posts_per_page', $post_number);
			}
		}
	}
}
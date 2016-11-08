<?php

//Define products post type
add_action('init', 'ctct_cpost_products');
if(!function_exists('ctct_cpost_products')){
	function ctct_cpost_products(){
		$labels = array('name' => __('Products', 'ctct'),
		'singular_name' => __('Product', 'ctct'),
		'add_new' => __('Add Product', 'ctct'),
		'add_new_item' => __('Add New Product', 'ctct'),
		'edit_item' => __('Edit Product', 'ctct'),
		'new_item' => __('New Product', 'ctct'),
		'view_item' => __('View Products', 'ctct'),
		'search_items' => __('Search Products', 'ctct'),
		'not_found' =>  __('No products found.', 'ctct'),
		'not_found_in_trash' => __('No products found in the trash.', 'ctct'), 
		'parent_item_colon' => '');
		
		$slug = ctct_get_option('slug_product');
		if($slug == '') $slug = 'product';
		$fields = array('labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'rewrite' => array('slug' => apply_filters('cpotheme_slug_product', $slug)),
		'capability_type' => 'page',
		'hierarchical' => false,
		'menu_icon' => 'dashicons-cart',
		'menu_position' => null,
		'show_in_nav_menus' => true,
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes')); 
		
		register_post_type('cpo_product', $fields);
	}
}

//Define admin columns in products post type	
add_filter('manage_edit-cpo_product_columns', 'ctct_cpost_products_columns');
if(!function_exists('ctct_cpost_products_columns')){
	function ctct_cpost_products_columns($columns){
		$columns = array(
		'cb' => '<input type="checkbox" />',
		'cpo-image' => __('Image', 'ctct'),
		'title' => __('Title', 'ctct'),
		'cpo-product-cats' => __('Categories', 'ctct'),
		'cpo-product-tags' => __('Tags', 'ctct'),
		'date' => __('Date', 'ctct'),
		'comments' => '<span class="vers"><span title="'.__('Comments', 'ctct').'" class="comment-grey-bubble"></span></span>',
		'author' => __('Author', 'ctct'),
		);
		return $columns;
	}
}
	
//Define products category taxonomy
add_action('init', 'ctct_tax_productctategory');
if(!function_exists('ctct_tax_productctategory')){
	function ctct_tax_productctategory() 
	{
		$labels = array('name' => __('Product Categories', 'ctct'),
		'singular_name' => __('Product Category', 'ctct'),
		'add_new' => __('New Product Category', 'ctct'),
		'add_new_item' => __('Add Product Category', 'ctct'),
		'edit_item' => __('Edit Product Category', 'ctct'),
		'new_item' => __('New Product Category', 'ctct'),
		'view_item' => __('View Product Category', 'ctct'),
		'search_items' => __('Search Product Categories', 'ctct'),
		'not_found' =>  __('No products categories were found.', 'ctct'),
		'not_found_in_trash' => __('No products categories were found in the trash.', 'ctct'), 
		'parent_item_colon' => '');
		
		$slug = ctct_get_option('slug_product_category');
		if($slug == '') $slug = 'product-category';
		$fields = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'rewrite' => array('slug' => apply_filters('cpotheme_slug_product_category', $slug)),
		'hierarchical' => true); 
		
		register_taxonomy('cpo_product_category', 'cpo_product', $fields);
	}
}
	
//Define products tag taxonomy
add_action('init', 'ctct_tax_productstag');
if(!function_exists('ctct_tax_productstag')){
	function ctct_tax_productstag() 
	{
		//Set up labels
		$labels = array('name' => __('Product Tags', 'ctct'),
		'singular_name' => __('Product Tag', 'ctct'),
		'add_new' => __('New Product Tag', 'ctct'),
		'add_new_item' => __('Add Product Tag', 'ctct'),
		'edit_item' => __('Edit Product Tag', 'ctct'),
		'new_item' => __('New Product Tag', 'ctct'),
		'view_item' => __('View Product Tag', 'ctct'),
		'search_items' => __('Search Product Tags', 'ctct'),
		'not_found' =>  __('No product tags were found.', 'ctct'),
		'not_found_in_trash' => __('No product tags were found in the trash.', 'ctct'), 
		'parent_item_colon' => '');
		
		$slug = ctct_get_option('slug_product_tag');
		if($slug == '') $slug = 'product-tag';
		$fields = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'rewrite' => array('slug' => apply_filters('cpotheme_slug_product_tag', $slug)),
		'hierarchical' => false); 
		
		register_taxonomy('cpo_product_tag', 'cpo_product', $fields);
	}
}
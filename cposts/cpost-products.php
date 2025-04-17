<?php

//Define products post type
add_action( 'init', 'ctct_cpost_products' );
if ( ! function_exists( 'ctct_cpost_products' ) ) {
	function ctct_cpost_products() {
		$labels = array(
			'name'               => __( 'Products', 'cpo-content-types' ),
			'singular_name'      => __( 'Product', 'cpo-content-types' ),
			'add_new'            => __( 'Add Product', 'cpo-content-types' ),
			'add_new_item'       => __( 'Add New Product', 'cpo-content-types' ),
			'edit_item'          => __( 'Edit Product', 'cpo-content-types' ),
			'new_item'           => __( 'New Product', 'cpo-content-types' ),
			'view_item'          => __( 'View Products', 'cpo-content-types' ),
			'search_items'       => __( 'Search Products', 'cpo-content-types' ),
			'not_found'          => __( 'No products found.', 'cpo-content-types' ),
			'not_found_in_trash' => __( 'No products found in the trash.', 'cpo-content-types' ),
			'parent_item_colon'  => '',
		);

		$slug = ctct_get_option( 'slug_product' );
		if ( '' === $slug ) {
			$slug = 'product';
		}
		$fields = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => apply_filters( 'cpotheme_slug_product', $slug ) ),
			'capability_type'    => 'page',
			'hierarchical'       => false,
			'menu_icon'          => 'dashicons-cart',
			'menu_position'      => null,
			'show_in_nav_menus'  => true,
			'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		);

		register_post_type( 'cpo_product', $fields );
	}
}

//Define admin columns in products post type
add_filter( 'manage_edit-cpo_product_columns', 'ctct_cpost_products_columns' );
if ( ! function_exists( 'ctct_cpost_products_columns' ) ) {
	function ctct_cpost_products_columns( $columns ) {
		$columns = array(
			'cb'               => '<input type="checkbox" />',
			'cpo-image'        => __( 'Image', 'cpo-content-types' ),
			'title'            => __( 'Title', 'cpo-content-types' ),
			'cpo-product-cats' => __( 'Categories', 'cpo-content-types' ),
			'cpo-product-tags' => __( 'Tags', 'cpo-content-types' ),
			'date'             => __( 'Date', 'cpo-content-types' ),
			'comments'         => '<span class="vers"><span title="' . __( 'Comments', 'cpo-content-types' ) . '" class="comment-grey-bubble"></span></span>',
			'author'           => __( 'Author', 'cpo-content-types' ),
		);
		return $columns;
	}
}

//Define products category taxonomy
add_action( 'init', 'ctct_tax_productctategory' );
if ( ! function_exists( 'ctct_tax_productctategory' ) ) {
	function ctct_tax_productctategory() {
		$labels = array(
			'name'               => __( 'Product Categories', 'cpo-content-types' ),
			'singular_name'      => __( 'Product Category', 'cpo-content-types' ),
			'add_new'            => __( 'New Product Category', 'cpo-content-types' ),
			'add_new_item'       => __( 'Add Product Category', 'cpo-content-types' ),
			'edit_item'          => __( 'Edit Product Category', 'cpo-content-types' ),
			'new_item'           => __( 'New Product Category', 'cpo-content-types' ),
			'view_item'          => __( 'View Product Category', 'cpo-content-types' ),
			'search_items'       => __( 'Search Product Categories', 'cpo-content-types' ),
			'not_found'          => __( 'No products categories were found.', 'cpo-content-types' ),
			'not_found_in_trash' => __( 'No products categories were found in the trash.', 'cpo-content-types' ),
			'parent_item_colon'  => '',
		);

		$slug = ctct_get_option( 'slug_product_category' );
		if ( '' === $slug ) {
			$slug = 'product-category';
		}
		$fields = array(
			'labels'            => $labels,
			'public'            => true,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'rewrite'           => array( 'slug' => apply_filters( 'cpotheme_slug_product_category', $slug ) ),
			'hierarchical'      => true,
		);

		register_taxonomy( 'cpo_product_category', 'cpo_product', $fields );
	}
}

//Define products tag taxonomy
add_action( 'init', 'ctct_tax_productstag' );
if ( ! function_exists( 'ctct_tax_productstag' ) ) {
	function ctct_tax_productstag() {
		//Set up labels
		$labels = array(
			'name'               => __( 'Product Tags', 'cpo-content-types' ),
			'singular_name'      => __( 'Product Tag', 'cpo-content-types' ),
			'add_new'            => __( 'New Product Tag', 'cpo-content-types' ),
			'add_new_item'       => __( 'Add Product Tag', 'cpo-content-types' ),
			'edit_item'          => __( 'Edit Product Tag', 'cpo-content-types' ),
			'new_item'           => __( 'New Product Tag', 'cpo-content-types' ),
			'view_item'          => __( 'View Product Tag', 'cpo-content-types' ),
			'search_items'       => __( 'Search Product Tags', 'cpo-content-types' ),
			'not_found'          => __( 'No product tags were found.', 'cpo-content-types' ),
			'not_found_in_trash' => __( 'No product tags were found in the trash.', 'cpo-content-types' ),
			'parent_item_colon'  => '',
		);

		$slug = ctct_get_option( 'slug_product_tag' );
		if ( '' === $slug ) {
			$slug = 'product-tag';
		}
		$fields = array(
			'labels'            => $labels,
			'public'            => true,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'rewrite'           => array( 'slug' => apply_filters( 'cpotheme_slug_product_tag', $slug ) ),
			'hierarchical'      => false,
		);

		register_taxonomy( 'cpo_product_tag', 'cpo_product', $fields );
	}
}

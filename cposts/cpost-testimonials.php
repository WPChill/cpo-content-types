<?php

//Define testimonials post type
add_action( 'init', 'ctct_cpost_testimonials' );
function ctct_cpost_testimonials() {
	$show_ui = false;
	if ( defined( 'CPOTHEME_USE_TESTIMONIALS' ) || ctct_get_option( 'display_testimonials' ) ) {
		$show_ui = true;
	}

	//Set up labels
	$labels = array(
		'name'               => __( 'Testimonials', 'cpo-content-types' ),
		'singular_name'      => __( 'Testimonial', 'cpo-content-types' ),
		'add_new'            => __( 'Add Testimonial', 'cpo-content-types' ),
		'add_new_item'       => __( 'Add New Testimonial', 'cpo-content-types' ),
		'edit_item'          => __( 'Edit Testimonial', 'cpo-content-types' ),
		'new_item'           => __( 'New Testimonial', 'cpo-content-types' ),
		'view_item'          => __( 'View Testimonial', 'cpo-content-types' ),
		'search_items'       => __( 'Search Testimonials', 'cpo-content-types' ),
		'not_found'          => __( 'No testimonials found.', 'cpo-content-types' ),
		'not_found_in_trash' => __( 'No testimonials found in the trash.', 'cpo-content-types' ),
		'parent_item_colon'  => '',
	);

	$fields = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => $show_ui,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'page',
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-format-chat',
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'cpo_testimonial', $fields );
}

//Define admin columns in testimonials post type
add_filter( 'manage_edit-cpo_testimonial_columns', 'ctct_cpost_testimonials_columns' );
if ( ! function_exists( 'ctct_cpost_testimonials_columns' ) ) {
	function ctct_cpost_testimonials_columns( $columns ) {
		$columns = array(
			'cb'         => '<input type="checkbox" />',
			'ctct-image' => __( 'Image', 'cpo-content-types' ),
			'title'      => __( 'Title', 'cpo-content-types' ),
			'date'       => __( 'Date', 'cpo-content-types' ),
			'author'     => __( 'Author', 'cpo-content-types' ),
		);
		return $columns;
	}
}

<?php

//Define customizer sections
if ( ! function_exists( 'ctct_metadata_sections' ) ) {
	function ctct_metadata_sections() {
		$data = array();

		$data['ctct_portfolio'] = array(
			'label'       => __( 'Portfolio', 'cpo-content-types' ),
			'description' => __( 'Set up custom slugs for the portfolio content type.', 'cpo-content-types' ),
		);

		$data['ctct_services'] = array(
			'label'       => __( 'Services', 'cpo-content-types' ),
			'description' => __( 'Set up custom slugs for the service content type.', 'cpo-content-types' ),
		);

		$data['ctct_team'] = array(
			'label'       => __( 'Team Members', 'cpo-content-types' ),
			'description' => __( 'Set up custom slugs for the team members content type.', 'cpo-content-types' ),
		);

		$data['ctct_display'] = array(
			'label'       => __( 'Content Types', 'cpo-content-types' ),
			'description' => __( 'Activate specific content types in the admin area, even when using a WordPress theme that does not support it.', 'cpo-content-types' ),
		);

		return apply_filters( 'ctct_metadata_sections', $data );
	}
}


//Settings
if ( ! function_exists( 'ctct_metadata_settings' ) ) {
	function ctct_metadata_settings() {
		$data = array();

		$data['slug_portfolio'] = array(
			'label'       => __( 'Portfolio Slug', 'cpo-content-types' ),
			'description' => __( 'Indicates the slug to be used in the URL for individual portfolio items.', 'cpo-content-types' ),
			'section'     => 'ctct_portfolio',
			'type'        => 'text',
			'width'       => '250px',
			'placeholder' => 'portfolio-item',
		);

		$data['slug_portfolio_category'] = array(
			'label'       => __( 'Portfolio Category Slug', 'cpo-content-types' ),
			'description' => __( 'Indicates the slug to be used in the URL for portfolio categories.', 'cpo-content-types' ),
			'section'     => 'ctct_portfolio',
			'type'        => 'text',
			'class'       => 'half-text',
			'placeholder' => 'portfolio-category',
		);

		$data['slug_portfolio_tag'] = array(
			'label'       => __( 'Portfolio Tag Slug', 'cpo-content-types' ),
			'description' => __( 'Indicates the slug to be used in the URL for portfolio tags.', 'cpo-content-types' ),
			'section'     => 'ctct_portfolio',
			'type'        => 'text',
			'placeholder' => 'portfolio-tag',
		);

		$data['slug_service'] = array(
			'label'       => __( 'Service Slug', 'cpo-content-types' ),
			'description' => __( 'Indicates the slug to be used in the URL for individual services.', 'cpo-content-types' ),
			'section'     => 'ctct_services',
			'type'        => 'text',
			'width'       => '250px',
			'placeholder' => 'service',
		);

		$data['slug_service_category'] = array(
			'label'       => __( 'Service Category Slug', 'cpo-content-types' ),
			'description' => __( 'Indicates the slug to be used in the URL for service categories.', 'cpo-content-types' ),
			'section'     => 'ctct_services',
			'type'        => 'text',
			'placeholder' => 'service-category',
		);

		$data['slug_service_tag'] = array(
			'label'       => __( 'Service Tag Slug', 'cpo-content-types' ),
			'description' => __( 'Indicates the slug to be used in the URL for service tags.', 'cpo-content-types' ),
			'section'     => 'ctct_services',
			'type'        => 'text',
			'placeholder' => 'service-tag',
		);

		$data['slug_team_category'] = array(
			'label'       => __( 'Team Group Slug', 'cpo-content-types' ),
			'description' => __( 'Indicates the slug to be used in the URL for team groups.', 'cpo-content-types' ),
			'section'     => 'ctct_team',
			'type'        => 'text',
			'placeholder' => 'team-group',
		);

		$data['display_slides'] = array(
			'label'       => __( 'Display Slides', 'cpo-content-types' ),
			'description' => __( 'Show this content type.', 'cpo-content-types' ),
			'section'     => 'ctct_display',
			'type'        => 'checkbox',
		);

		$data['display_features'] = array(
			'label'       => __( 'Display Features', 'cpo-content-types' ),
			'description' => __( 'Show this content type.', 'cpo-content-types' ),
			'section'     => 'ctct_display',
			'type'        => 'checkbox',
		);

		$data['display_portfolio'] = array(
			'label'       => __( 'Display Portfolio', 'cpo-content-types' ),
			'description' => __( 'Show this content type.', 'cpo-content-types' ),
			'section'     => 'ctct_display',
			'type'        => 'checkbox',
		);

		$data['display_services'] = array(
			'label'       => __( 'Display Services', 'cpo-content-types' ),
			'description' => __( 'Show this content type.', 'cpo-content-types' ),
			'section'     => 'ctct_display',
			'type'        => 'checkbox',
		);

		$data['display_team'] = array(
			'label'       => __( 'Display Team Members', 'cpo-content-types' ),
			'description' => __( 'Show this content type.', 'cpo-content-types' ),
			'section'     => 'ctct_display',
			'type'        => 'checkbox',
		);

		$data['display_testimonials'] = array(
			'label'       => __( 'Display Testimonials', 'cpo-content-types' ),
			'description' => __( 'Show this content type.', 'cpo-content-types' ),
			'section'     => 'ctct_display',
			'type'        => 'checkbox',
		);

		$data['display_clients'] = array(
			'label'       => __( 'Display Clients', 'cpo-content-types' ),
			'description' => __( 'Show this content type.', 'cpo-content-types' ),
			'section'     => 'ctct_display',
			'type'        => 'checkbox',
		);

		return apply_filters( 'ctct_metadata_settings', $data );
	}
}

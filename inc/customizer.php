<?php
/**
 * bigsky-theme Theme Customizer
 *
 * @package bigsky-theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function big_sky_pictures_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'big_sky_pictures_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'big_sky_pictures_customize_partial_blogdescription',
			)
		);
	}

	// Add Social Media Section
	$wp_customize->add_section( 'big_sky_social_media', array(
		'title'    => __( 'Social Media', 'big-sky-pictures' ),
		'priority' => 120,
	) );

	// Facebook URL
	$wp_customize->add_setting( 'facebook_url', array(
		'default'           => 'https://facebook.com/bigskypictures',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'facebook_url', array(
		'label'   => __( 'Facebook URL', 'big-sky-pictures' ),
		'section' => 'big_sky_social_media',
		'type'    => 'url',
	) );

	// Instagram URL
	$wp_customize->add_setting( 'instagram_url', array(
		'default'           => 'https://instagram.com/bigskypictures',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'instagram_url', array(
		'label'   => __( 'Instagram URL', 'big-sky-pictures' ),
		'section' => 'big_sky_social_media',
		'type'    => 'url',
	) );
}
add_action( 'customize_register', 'big_sky_pictures_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function big_sky_pictures_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function big_sky_pictures_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function big_sky_pictures_customize_preview_js() {
	wp_enqueue_script( 'big-sky-pictures-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'big_sky_pictures_customize_preview_js' );

<?php
/**
 * oncue Theme Customizer
 *
 * @package oncue
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function oncue_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'oncue_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'oncue_customize_partial_blogdescription',
		) );
		
		
	}
	/** 
  header Background Color
  **/
	$wp_customize->add_setting(
      'oncue_header_color', //give it an ID
      array(
		'transport' => 'postMessage',
        'default' => '#ffffff', // Give it a default
		'sanitize_callback' => 'sanitize_hex_color',
      )
	);
	$wp_customize->add_control(
     new WP_Customize_Color_Control(
         $wp_customize,
         'oncue_header_color', //give it an ID
         array(
             'label'      => __( 'Header Background Color', 'oncue' ), //set the label to appear in the Customizer
             'section'    => 'colors', //select the section for it to appear under  
             'settings'   => 'oncue_header_color' //pick the setting it applies to
         )
    )
  );
	
	/** Footer Background Color**/
	$wp_customize->add_setting(
      'oncue_footer_color', //give it an ID
      array(
        'default' => '#333333', // Give it a default
		'transport'   => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
      )
	);
	$wp_customize->add_control(
     new WP_Customize_Color_Control(
         $wp_customize,
         'oncue_footer_color', //give it an ID
         array(
             'label'      => __( 'Footer Background Color', 'oncue' ), //set the label to appear in the Customizer
             'section'    => 'colors', //select the section for it to appear under  
             'settings'   => 'oncue_footer_color' //pick the setting it applies to
         )
    )
  );
  
  function sanitize_float( $input ) {
    return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

}
add_action( 'customize_register', 'oncue_customize_register' );


/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function oncue_customize_partial_blogname() {
	bloginfo( 'name' );
}


/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function oncue_customize_partial_blogdescription() {
	bloginfo( 'description' );
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function oncue_customize_preview_js() {
	wp_enqueue_script( 'oncue-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'oncue_customize_preview_js' );

add_action( 'wp_head', 'oncue_customize_css' );
/*
 * Output our custom Accent Color setting CSS Style
 *
 */
function oncue_customize_css() {
?>
<style type="text/css">
.footer {
    background-color: <?php echo esc_attr(get_theme_mod('oncue_footer_color', '#333333')); // add in your add_settings ID and default value ?>; }

    .nav-header {
        background-color: <?php echo esc_attr(get_theme_mod('oncue_header_color', '#ffffff')); // add in your add_settings ID and default value ?>; }
</style>
<?php
}
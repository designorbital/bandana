<?php
/**
 * Bandana Theme Customizer
 *
 * @package Bandana
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bandana_customize_register ( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/**
	 * Theme Options Panel
	 */
	$wp_customize->add_panel( 'bandana_theme_options', array(
	    'title'     => esc_html__( 'Theme Options', 'bandana' ),
	    'priority'  => 1,
	) );

	/**
	 * General Options Section
	 */
	$wp_customize->add_section( 'bandana_general_options', array (
		'title'     => esc_html__( 'General Options', 'bandana' ),
		'panel'     => 'bandana_theme_options',
		'priority'  => 10,
		'description' => esc_html__( 'Personalize the settings of your theme.', 'bandana' ),
	) );

	// Main Sidebar Position
	$wp_customize->add_setting ( 'bandana_sidebar_position', array (
		'default'           => bandana_default( 'bandana_sidebar_position' ),
		'sanitize_callback' => 'bandana_sanitize_select',
	) );

	$wp_customize->add_control ( 'bandana_sidebar_position', array (
		'label'    => esc_html__( 'Main Sidebar Position (if active)', 'bandana' ),
		'section'  => 'bandana_general_options',
		'priority' => 1,
		'type'     => 'select',
		'choices'  => array(
			'right' => esc_html__( 'Right', 'bandana'),
			'left'  => esc_html__( 'Left',  'bandana'),
		),
	) );

	/**
	 * Theme Support Section
	 */
	$wp_customize->add_section( 'bandana_support', array(
		'title'       => esc_html__( 'Support Options', 'bandana' ),
		'description' => esc_html__( 'Thanks for your interest in Bandana Lite! Following links will be helpful to you.', 'bandana' ),
		'panel'       => 'bandana_theme_options',
		'priority'    => 20,
	) );

	// Theme
	$wp_customize->add_setting ( 'bandana_theme_about', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new Bandana_WP_Customize_Control_Button(
			$wp_customize,
			'bandana_theme_about',
			array(
				'label'         => esc_html__( 'Bandana Lite vs Bandana Pro', 'bandana' ),
				'section'       => 'bandana_support',
				'priority'      => 1,
				'type'          => 'bandana_button',
				'button_tag'    => 'a',
				'button_class'  => 'button button-primary',
				'button_href'   => 'https://designorbital.com/bandana/',
				'button_target' => '_blank',
			)
		)
	);

	// Documentation
	$wp_customize->add_setting ( 'bandana_theme_doc', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new Bandana_WP_Customize_Control_Button(
			$wp_customize,
			'bandana_theme_doc',
			array(
				'label'         => esc_html__( 'Bandana Documentation', 'bandana' ),
				'section'       => 'bandana_support',
				'priority'      => 2,
				'type'          => 'bandana_button',
				'button_tag'    => 'a',
				'button_class'  => 'button button-primary',
				'button_href'   => 'https://designorbital.com/bandana-documentation/',
				'button_target' => '_blank',
			)
		)
	);

	// Support
	$wp_customize->add_setting ( 'bandana_theme_support', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new Bandana_WP_Customize_Control_Button(
			$wp_customize,
			'bandana_theme_support',
			array(
				'label'         => esc_html__( 'General Support', 'bandana' ),
				'section'       => 'bandana_support',
				'priority'      => 3,
				'type'          => 'bandana_button',
				'button_tag'    => 'a',
				'button_class'  => 'button button-primary',
				'button_href'   => 'https://designorbital.com/contact/',
				'button_target' => '_blank',
			)
		)
	);

	/**
	 * Theme Pro Section
	 */
	$wp_customize->add_section( 'bandana_pro', array(
		'title'       => esc_html__( 'About Bandana Pro', 'bandana' ),
		'description' => esc_html__( 'Bandana Pro is premium WordPress theme with lot of additional features and support forum access. Please visit the link below to know more about Bandana Pro theme.', 'bandana' ),
		'panel'       => 'bandana_theme_options',
		'priority'    => 30,
	) );

	// Theme
	$wp_customize->add_setting ( 'bandana_pro_about', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new Bandana_WP_Customize_Control_Button(
			$wp_customize,
			'bandana_pro_about',
			array(
				'label'         => esc_html__( 'Bandana Pro', 'bandana' ),
				'section'       => 'bandana_pro',
				'priority'      => 1,
				'type'          => 'bandana_button',
				'button_tag'    => 'a',
				'button_class'  => 'button button-primary',
				'button_href'   => 'https://designorbital.com/bandana-pro/',
				'button_target' => '_blank',
			)
		)
	);

}
add_action( 'customize_register', 'bandana_customize_register' );

/**
 * Sanitize Select.
 *
 * @param string $input Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function bandana_sanitize_select( $input, $setting ) {

	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Button Control Class
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

	class Bandana_WP_Customize_Control_Button extends WP_Customize_Control {
		/**
		 * @access public
		 * @var string
		 */
		public $type = 'bandana_button';

		/**
		 * HTML tag to render button object.
		 *
		 * @var  string
		 */
		protected $button_tag = 'button';

		/**
		 * Class to render button object.
		 *
		 * @var  string
		 */
		protected $button_class = 'button button-primary';

		/**
		 * Link for <a> based button.
		 *
		 * @var  string
		 */
		protected $button_href = 'javascript:void(0)';

		/**
		 * Target for <a> based button.
		 *
		 * @var  string
		 */
		protected $button_target = '';

		/**
		 * Click event handler.
		 *
		 * @var  string
		 */
		protected $button_onclick = '';

		/**
		 * ID attribute for HTML tab.
		 *
		 * @var  string
		 */
		protected $button_tag_id = '';

		/**
		 * Render the control's content.
		 */
		public function render_content() {
		?>
			<span class="center">
				<?php
				// Print open tag
				echo '<' . esc_html( $this->button_tag );

				// button class
				if ( ! empty( $this->button_class ) ) {
					echo ' class="' . esc_attr( $this->button_class ) . '"';
				}

				// button or href
				if ( 'button' == $this->button_tag ) {
					echo ' type="button"';
				} else {
					echo ' href="' . esc_url( $this->button_href ) . '"' . ( empty( $this->button_tag ) ? '' : ' target="' . esc_attr( $this->button_target ) . '"' );
				}

				// onClick Event
				if ( ! empty( $this->button_onclick ) ) {
					echo ' onclick="' . esc_js( $this->button_onclick ) . '"';
				}

				// ID
				if ( ! empty( $this->button_tag_id ) ) {
					echo ' id="' . esc_attr( $this->button_tag_id ) . '"';
				}

				echo '>';

				// Print text inside tag
				echo esc_html( $this->label );

				// Print close tag
				echo '</' . esc_html( $this->button_tag ) . '>';
				?>
			</span>
		<?php
		}
	}

}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bandana_customize_preview_js() {
	wp_enqueue_script( 'bandana_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20140120', true );
}
add_action( 'customize_preview_init', 'bandana_customize_preview_js' );

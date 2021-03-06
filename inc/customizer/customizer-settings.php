<?php

/**
 * ASU Web Standards 2020 Theme Customizer
 *
 * @package asu-web-standards-2020
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if (!function_exists('asu_wp2020_register_theme_customizer_settings')) {
	/**
	 * Register custom ASU Web Standards settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function asu_wp2020_register_theme_customizer_settings($wp_customize)
	{
		if (!class_exists('Prefix_Separator_Control')) {
			/**
			 * Class Prefix_Separator_Control
			 *
			 * Custom control to display separator
			 */
			class Prefix_Separator_Control extends WP_Customize_Control
			{
				public function render_content()
				{
?>
					<label>
						<br>
						<hr>
						<br>
					</label>
<?php
				}
			}
		}

		// ==============================================================
		// ==============================================================
		// = Remove Default Wordpress Customizer Controls and Sections  =
		// ==============================================================
		// ==============================================================
		$wp_customize->remove_section('background_image');
		$wp_customize->remove_section('colors');
		$wp_customize->remove_section('header_image');

		$wp_customize->remove_control('site_icon');
		$wp_customize->remove_control('custom_logo');


		//  ================================
		//  ================================
		//  = Rename Site Identity Section =
		//  ================================
		//  ================================

		$wp_customize->get_section('title_tagline')->title = __('Site Information');


		//  =============================
		//  = Parent Unit Name  =
		//  =============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[parent_unit_name]',
			array(
				'default'           => '',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_parent_unit_name',
			array(
				'label'      => __('Parent Unit', 'asu-web-standards'),
				'section'    => 'title_tagline',
				'settings'   => 'asu_wp2020_theme_options[parent_unit_name]',
				'priority'   => 20,
			)
		);

		//  =============================
		//  = Parent Unit URL           =
		//  =============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[parent_unit_link]',
			array(
				'default'           => '',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_parent_unit_link',
			array(
				'label'      => __('Parent Unit URL', 'asu-web-standards'),
				'section'    => 'title_tagline',
				'settings'   => 'asu_wp2020_theme_options[parent_unit_link]',
				'priority'   => 30,
			)
		);

		//  ================================
		//  = Section Separator            =
		//  ================================
		$wp_customize->add_setting(
			'prefix_separator[0]',
			array(
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);
		$wp_customize->add_control(
			new Prefix_Separator_Control(
				$wp_customize,
				'prefix_separator[0]',
				array(
					'section' => 'title_tagline',
					'priority'          => 40,
				)
			)
		);

		//  =============================
		//  = Unit Logo Select   =
		//  =============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[logo_select]',
			array(
				'default'           => 'none',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'edit_theme_options',
			)
		);

		// load array of endorsed units and cache in transients
		$endorsedLogos = asu_wp2020_theme_get_endorsed_unit_logos();

		// Load options list
		$logoOptions = array();
		foreach ($endorsedLogos as $logo) {
			$logoOptions[$logo['slug']] = __($logo['name'], 'asu-web-standards');
		}

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'asu_wp2020_logo_select',
				array(
					'label'             => __('Endorsed Logos Presets', 'asu-web-standards'),
					'description'       => __(
						'Select the appropriate unit logo, if available.',
						'asu-web-standards'
					),
					'section'           => 'title_tagline',
					'settings'          => 'asu_wp2020_theme_options[logo_select]',
					'type'              => 'select',
					'sanitize_callback' => 'asu_wp2020_sanitize_select',
					'choices'           => $logoOptions,
					'priority'          => 50,
				)
			)
		);

		//  =============================
		//  = Unit Logo URL      =
		//  =============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[logo_url]',
			array(
				'default'           => '',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_logo_url',
			array(
				'label'      => __('Unit Endorsed Logo URL', 'asu-web-standards'),
				'description'       => __(
					'Enter full url to an alternate endorsed logo. This field has no effect when Preset is selected above.',
					'asu-web-standards'
				),
				'section'    => 'title_tagline',
				'settings'   => 'asu_wp2020_theme_options[logo_url]',
				'priority'   => 60,
			)
		);


		//  ================================
		//  = Section Separator            =
		//  ================================
		$wp_customize->add_setting(
			'prefix_separator[1]',
			array(
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);
		$wp_customize->add_control(
			new Prefix_Separator_Control(
				$wp_customize,
				'prefix_separator[1]',
				array(
					'section' => 'title_tagline',
					'priority'          => 70,
				)
			)
		);

		//  =============================
		//  = Contact Us Email or URL   =
		//  =============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[contact_email]',
			array(
				'default'        => '',
				'capability'     => 'edit_theme_options',
				'type'           => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_email_or_url',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_contact_email',
			array(
				'label'      => __('Contact Us Email or URL', 'asu-web-standards'),
				'section'    => 'title_tagline',
				'settings'   => 'asu_wp2020_theme_options[contact_email]',
				'priority'   => 80,
			)
		);

		//  =============================
		//  = Contact Us Email Subject  =
		//  =============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[contact_subject]',
			array(
				'default'           => '',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_contact_subject',
			array(
				'label'      => __('Contact Us Email Subject (Optional)', 'asu-web-standards'),
				'section'    => 'title_tagline',
				'settings'   => 'asu_wp2020_theme_options[contact_subject]',
				'priority'   => 90,
			)
		);

		//  =============================
		//  = Contact Us Email Body     =
		//  =============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[contact_body]',
			array(
				'default'           => '',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_contact_body',
			array(
				'label'    => __('Contact Us Email Body (Optional)', 'asu-web-standards'),
				'section'  => 'title_tagline',
				'settings' => 'asu_wp2020_theme_options[contact_body]',
				'type'     => 'textarea',
				'priority' => 100,
			)
		);

		//  =============================
		//  = Contribute URL            =
		//  =============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[contribute_url]',
			array(
				'default'           => '',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_url',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_contribute_url',
			array(
				'label'      => __('Contribute URL (Optional)', 'asu-web-standards'),
				'section'    => 'title_tagline',
				'settings'   => 'asu_wp2020_theme_options[contribute_url]',
				'priority'   => 110,
			)
		);

		//  =============================
		//  =============================
		//  = ASU Header Section         =
		//  =============================
		//  =============================

		$wp_customize->add_section(
			'asu_wp2020_theme_section_header',
			array(
				'title'      => __('ASU Global Header', 'asu-web-standards'),
				'priority'   => 20,
			)
		);

		//  ===============================================================
		//  = ASU Header - Toggle Navigation Menu for Landing Pages
		//  ===============================================================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[header_navigation_menu]',
			array(
				'default'           => 'enabled',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);
		$wp_customize->add_control(
			'asu_wp2020_header_navigation_menu',
			array(
				'label'      => __('Header - Navigation Menu', 'asu-web-standards'),
				'description'       => __(
					'Enable/disable the navigation menu in the ASU header. This is approved for Landing Page sites.',
					'asu-web-standards'
				),
				'section'    => 'asu_wp2020_theme_section_header',
				'settings'   => 'asu_wp2020_theme_options[header_navigation_menu]',
				'type'       => 'radio',
				'choices'    => array(
					'enabled'  => 'enabled',
					'disabled' => 'disabled',
				),
			)
		);


		//  =============================
		//  =============================
		//  = ASU Footer Section        =
		//  =============================
		//  =============================

		$wp_customize->add_section(
			'asu_wp2020_theme_section_footer',
			array(
				'title'      => __('ASU Global Footer', 'asu-web-standards'),
				'priority'   => 20,
			)
		);

		//  ===============================================================
		//  = ASU Footer - Toggle Branding Row - Unit Logo and Social Media
		//  ===============================================================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[footer_row_branding]',
			array(
				'default'           => 'enabled',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);
		$wp_customize->add_control(
			'asu_wp2020_footer_row_branding',
			array(
				'label'      => __('Footer - Logo & Social Media Row', 'asu-web-standards'),
				'description'       => __(
					'Enable/disable the Logo and Social Media row in the ASU footer.',
					'asu-web-standards'
				),
				'section'    => 'asu_wp2020_theme_section_footer',
				'settings'   => 'asu_wp2020_theme_options[footer_row_branding]',
				'type'       => 'radio',
				'choices'    => array(
					'enabled'  => 'enabled',
					'disabled' => 'disabled',
				),
			)
		);

		//  =======================================================
		//  = ASU Footer - Toggle Actions Row - Unit Info and Menus
		//  =======================================================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[footer_row_actions]',
			array(
				'default'           => 'enabled',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);
		$wp_customize->add_control(
			'asu_wp2020_footer_row_actions',
			array(
				'label'      => __('Footer - Actions Row', 'asu-web-standards'),
				'description'       => __(
					'Enable/disable the Unit contact and menus row in the ASU footer.',
					'asu-web-standards'
				),
				'section'    => 'asu_wp2020_theme_section_footer',
				'settings'   => 'asu_wp2020_theme_options[footer_row_actions]',
				'type'       => 'radio',
				'choices'    => array(
					'enabled'  => 'enabled',
					'disabled' => 'disabled',
				),
			)
		);

		//  =============================
		//  =============================
		//  = ASU Search Section        =
		//  =============================
		//  =============================

		$wp_customize->add_section(
			'asu_wp2020_theme_section_asu_search',
			array(
				'title'      => __('ASU Search', 'asu-web-standards'),
				'priority'   => 30,
			)
		);

		$wp_customize->add_setting(
			'asu_wp2020_theme_options[asu_search]',
			array(
				'default'           => 'enabled',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_asu_search',
			array(
				'label'      => __('ASU Search', 'asu-web-standards'),
				'description'       => __(
					'Replace WP internal search service with ASU\'s search service',
					'asu-web-standards'
				),
				'section'    => 'asu_wp2020_theme_section_asu_search',
				'settings'   => 'asu_wp2020_theme_options[asu_search]',
				'type'       => 'radio',
				'choices'    => array(
					'enabled'  => 'enabled',
					'disabled' => 'disabled',
				),
			)
		);

		//  ==================================
		//  ==================================
		//  = ASU Analytics Manager Section =
		//  ==================================
		//  ==================================

		$wp_customize->add_section(
			'asu_wp2020_theme_section_asu_analytics',
			array(
				'title'      => __('ASU Analytics', 'asu-web-standards'),
				'priority'   => 40,
			)
		);

		//  =======================================
		//  = ASU Marketing Hub Analytics Manager =
		//  =======================================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[asu_hub_analytics]',
			array(
				'default'           => 'disabled',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_asu_hub_analytics',
			array(
				'label'      => __('ASU Marketing Hub Analytics', 'asu-web-standards'),
				'description'       => __(
					'Enable the ASU Marketing Hub\'s analytics package. This must be active on all production ASU web sites.',
					'asu-web-standards'
				),
				'section'    => 'asu_wp2020_theme_section_asu_analytics',
				'settings'   => 'asu_wp2020_theme_options[asu_hub_analytics]',
				'type'       => 'radio',
				'choices'    => array(
					'enabled'  => 'enabled',
					'disabled' => 'disabled',
				),
			)
		);

		//  ==============================
		//  = Site Google Tag Manager    =
		//  ==============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[site_gtm_container_id]',
			array(
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_site_gtm_container_id',
			array(
				'label'             => __('Google Tag Manager container ID', 'asu-web-standards'),
				'description'       => __(
					'Enter your unit\'s GTM container ID to enable analytics for this website. Note: Enabling GTM and GA at the same time can negatively impact page performance.',
					'asu-web-standards'
				),
				'section'           => 'asu_wp2020_theme_section_asu_analytics',
				'settings'          => 'asu_wp2020_theme_options[site_gtm_container_id]',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		//  ==============================
		//  = Site Google Analytics ID   =
		//  ==============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[site_ga_tracking_id]',
			array(
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_site_ga_tracking_id',
			array(
				'label'             => __('Google Analytics Tracking ID', 'asu-web-standards'),
				'description'       => __(
					'Enter your unit\'s GA Tracking ID to enable analytics for this website. Note: Enabling GTM and GA at the same time can negatively impact page performance.',
					'asu-web-standards'
				),
				'section'           => 'asu_wp2020_theme_section_asu_analytics',
				'settings'          => 'asu_wp2020_theme_options[site_ga_tracking_id]',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		//  ==============================
		//  = Hotjar Analytics           =
		//  ==============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[hotjar_site_id]',
			array(
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		$wp_customize->add_control(
			'asu_wp2020_hotjar_site_id',
			array(
				'label'             => __('Hotjar Site ID', 'asu-web-standards'),
				'description'       => __(
					'Enter your Hotjar Site ID to enable Hotjar analytics for this website.',
					'asu-web-standards'
				),
				'section'           => 'asu_wp2020_theme_section_asu_analytics',
				'settings'          => 'asu_wp2020_theme_options[hotjar_site_id]',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);


		//  =============================
		//  =============================
		//  = 404 Image Section         =
		//  =============================
		//  =============================

		$wp_customize->add_section(
			'asu_wp2020_theme_section_404',
			array(
				'title'      => __('404 Image', 'asu-web-standards'),
				'priority'   => 50,
			)
		);

		//  =============================
		//  = 404 Image                 =
		//  =============================
		$wp_customize->add_setting(
			'asu_wp2020_theme_options[image_404]',
			array(
				'default'           => '',
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'asu_wp2020_sanitize_nothing',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'asu_wp2020_404',
				array(
					'label'      => __('404 Image', 'asu-web-standards'),
					'description'       => __(
						'Resize and crop your desired image to approximately 1200px x 500px',
						'asu-web-standards'
					),
					'section'    => 'asu_wp2020_theme_section_404',
					'settings'   => 'asu_wp2020_theme_options[image_404]',
				)
			)
		);

		//  ================================
		//  ================================
		//  = Theme Layout Manager Section =
		//  ================================
		//  ================================

		// Theme layout settings.
		$wp_customize->add_section(
			'asu_wp2020_theme_layout_options',
			array(
				'title'       => __('Theme Layout Settings', 'asu-web-standards'),
				'capability'  => 'edit_theme_options',
				'description' => __('Theme sidebar defaults', 'asu-web-standards'),
				'priority'    => 60,
			)
		);

		$wp_customize->add_setting(
			'asu_wp2020_theme_options[sidebars]',
			array(
				'default'           => 'left',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'edit_theme_options',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'asu_wp2020_sidebar_position',
				array(
					'label'             => __('Sidebar Positioning', 'asu-web-standards'),
					'description'       => __(
						'Set sidebar\'s default position. Can either be: right, left, both or none.',
						'asu-web-standards'
					),
					'section'           => 'asu_wp2020_theme_layout_options',
					'settings'          => 'asu_wp2020_theme_options[sidebars]',
					'type'              => 'select',
					'sanitize_callback' => 'asu_wp2020_sanitize_select',
					'choices'           => array(
						'right' => __('Right sidebar', 'asu-web-standards'),
						'left'  => __('Left sidebar', 'asu-web-standards'),
						'both'  => __('Left & Right sidebars', 'asu-web-standards'),
						'none'  => __('No sidebar', 'asu-web-standards'),
					),
					'priority'          => apply_filters('asu_wp2020_sidebar_position_priority', 20),
				)
			)
		);
	}
} // End of if function_exists( 'asu_wp2020_register_theme_customizer_settings' ).
add_action('customize_register', 'asu_wp2020_register_theme_customizer_settings');

<?php
/**
 * ASU Web Standards 2020 Theme modify editor
 *
 * @package asu-web-standards-2020
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', 'asu_wp2020_wpdocs_theme_add_editor_styles' );

if ( ! function_exists( 'asu_wp2020_wpdocs_theme_add_editor_styles' ) ) {
	/**
	 * Registers an editor stylesheet for the theme.
	 */
	function asu_wp2020_wpdocs_theme_add_editor_styles() {
		add_editor_style( 'css/custom-editor-style.min.css' );
	}
}

add_filter( 'mce_buttons_2', 'asu_wp2020_tiny_mce_style_formats' );

if ( ! function_exists( 'asu_wp2020_tiny_mce_style_formats' ) ) {
	/**
	 * Reveals TinyMCE's hidden Style dropdown.
	 *
	 * @param array $buttons Array of Tiny MCE's button ids.
	 * @return array
	 */
	function asu_wp2020_tiny_mce_style_formats( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}
}

add_filter( 'tiny_mce_before_init', 'asu_wp2020_tiny_mce_before_init' );

if ( ! function_exists( 'asu_wp2020_tiny_mce_before_init' ) ) {
	/**
	 * Adds style options to TinyMCE's Style dropdown.
	 *
	 * @param array $settings TinyMCE settings array.
	 * @return array
	 */
	function asu_wp2020_tiny_mce_before_init( $settings ) {

		$style_formats = array(
			array(
				'title'    => 'Lead Paragraph',
				'selector' => 'p',
				'classes'  => 'lead',
				'wrapper'  => true,
			),
			array(
				'title'  => 'Small',
				'inline' => 'small',
			),
			array(
				'title'   => 'Blockquote',
				'block'   => 'blockquote',
				'classes' => 'blockquote',
				'wrapper' => true,
			),
			array(
				'title'   => 'Blockquote Footer',
				'block'   => 'footer',
				'classes' => 'blockquote-footer',
				'wrapper' => true,
			),
			array(
				'title'  => 'Cite',
				'inline' => 'cite',
			),
		);

		if ( isset( $settings['style_formats'] ) ) {
			$orig_style_formats = json_decode( $settings['style_formats'], true );
			$style_formats      = array_merge( $orig_style_formats, $style_formats );
		}

		$settings['style_formats'] = wp_json_encode( $style_formats );
		return $settings;
	}
}

/**
 * Add inline css editor width
 */

function gutenberg_editor_full_width()
{
	echo '<style>
    body.gutenberg-editor-page .editor-post-title__block,
	body.gutenberg-editor-page .editor-default-block-appender,
	body.gutenberg-editor-page .editor-block-list__block {
		max-width: none !important;
	}
	.block-editor__container .wp-block {
		max-width: none !important;
	}
	/*code editor*/
	.edit-post-text-editor__body {
		max-width: none !important;
		margin-left: 5%;
		margin-right: 5%;
	}
</style>';
}
add_action('admin_head', 'gutenberg_editor_full_width');

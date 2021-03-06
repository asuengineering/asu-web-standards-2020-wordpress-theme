<?php

/**
 * ASU Web Standards 2020 Theme Customizer
 *
 * @package asu-web-standards-2020
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if (!function_exists('asu_wp2020_theme_get_endorsed_unit_logos')) {
	/**
	 * Load a list of endorsed-logos from JSON file and store in transient for quick retrieval.
	 *
	 * @return array The array of endorsed logo arrays.
	 */
	function asu_wp2020_theme_get_endorsed_unit_logos()
	{
		$transient = get_transient('asu_wp2020_endorsed_unit_logos');

		// Do we have this information in our transients already?
		// Yep, just return it and we're done. Ensure WP_DEBUG is not enabled.  (If debug is enabled, don't use transients cache)
		if (!empty($transient) && false === WP_DEBUG) {
			// The function will return here every time after the first time it is run, until the transient expires.
			return $transient;

			// Nope!  We gotta make a call.
		} else {
			// Get the contents of the JSON file containing the array of endorsed unit logos
			$strJsonFileContents = file_get_contents(get_template_directory() . "/img/endorsed-logo/unit-logos.json");
			// Convert to nested array
			$endorsedLogos = json_decode($strJsonFileContents, true);

			// Save the file system response so we don't have to call again for an hour.
			set_transient('asu_wp2020_endorsed_unit_logos', $endorsedLogos, HOUR_IN_SECONDS);

			// Return the array of endorsed logos.  The function will return here the first time it is run, and then once again, each time the transient expires.
			return $endorsedLogos;
		}
	}
}

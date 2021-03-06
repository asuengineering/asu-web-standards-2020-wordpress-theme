<?php

/**
 * The footer navigation menu
 *
 * @package asu-web-standards-2020
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$menu_name = 'footer';
$menu_items = asu_wp2020_get_menu_formatted_array($menu_name);

foreach ($menu_items as $item) :
	// A top-level menu item with children is formatted as a column with a header
	if (empty($item['menu_item_parent']) && !empty($item['children'])) :
?>
		<div class="col-xl flex-footer">
			<div class="card card-foldable desktop-disable-xl">
				<div class="card-header">
					<h5>
						<a id="footlink-header-<?= sanitize_title($item['title']) ?>" class="collapsed" data-toggle="collapse" href="#footlink-<?= sanitize_title($item['title']) ?>" role="button" aria-expanded="false" aria-controls="footlink-<?= sanitize_title($item['title']) ?>">
							<?= $item['title'] ?>
							<span class="fas fa-chevron-up"></span>
						</a>
					</h5>
				</div>
				<div id="footlink-<?= sanitize_title($item['title']) ?>" class="collapse card-body" aria-labelledby="footlink-header-<?= sanitize_title($item['title']) ?>">
					<?php
					$column = '';
					foreach ($item['children'] as $child) :
						$link = '<a class="nav-link" href="%1$s" title="%2$s">%2$s</a>';
						$column .= wp_kses(sprintf($link, $child['url'], $child['title']), wp_kses_allowed_html('post'));
					endforeach;
					echo $column;
					?>
				</div>
			</div>
		</div>
<?php
	endif;

endforeach;


// Because the Footer widgets enable page designs that may stress/violate Web Standards compliance,
// this widget zone is only enabled when a constant, ENABLE_FOOTER_WIDGETS, is set in wp-config.php:
// define('ENABLE_FOOTER_WIDGETS', true);
if (defined('ENABLE_FOOTER_WIDGETS') && true == ENABLE_FOOTER_WIDGETS && is_active_sidebar('sidebar-footer')) :
	dynamic_sidebar('sidebar-footer');
endif;

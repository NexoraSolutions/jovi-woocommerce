<?php
/**
 * The template for the default search.
 *
 * @package Salient WordPress Theme
 * @version 9.0.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
	<input type="text" class="search-field" placeholder="<?php echo esc_attr__('Buscar...', 'salient'); ?>" value="" name="s" title="<?php echo esc_attr__('Buscar por:', 'salient'); ?>" />
	<button type="submit" class="search-widget-btn"><span class="normal icon-salient-search" aria-hidden="true"></span><span class="text"><?php echo esc_html__('Buscar', 'salient'); ?></span></button>
</form>
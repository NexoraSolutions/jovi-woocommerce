<?php 

add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

function salient_child_enqueue_styles() {
		
		$nectar_theme_version = nectar_get_theme_version();
		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );
		
    if ( is_rtl() ) {
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
		}
}

// Remove default WooCommerce term description output on archives
add_action('wp', function () {
    remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
});

// Override Salient shop title to append product category description under the H1
if (!function_exists('salient_woo_shop_title')) {
    function salient_woo_shop_title() {
        echo '<h1 class="page-title">';
        woocommerce_page_title();
        echo '</h1>';

        // Append term description only on product category archives
        if (is_product_category()) {
            // Removes the automatics <p> from term descriptions
            remove_filter('term_description', 'wpautop');

            $desc = term_description(get_queried_object_id(), 'product_cat');
            if ($desc) {
                echo '<h2 class="term-description">' . wp_kses_post($desc) . '</h2>';
            }
        }
    }
}

?>

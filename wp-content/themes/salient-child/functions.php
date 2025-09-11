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

// Filter area.
if( !function_exists('nectar_product_filter_area_trigger') ) {
	function nectar_product_filter_area_trigger() {
		echo '<div class="nectar-shop-filters">
					<a href="#" class="nectar-shop-filter-trigger">
						<span class="toggle-icon">
							<span>
								<span class="top-line"></span>
								<span class="bottom-line"></span>
							</span>
						</span>
						<span class="text-wrap">
							<span class="dynamic">
								<span class="show">'.esc_html__('Mostrar','salient').'</span>
								<span class="hide">'.esc_html__('Ocultar','salient').'</span>
							</span> '.esc_html__('Filtros','salient').'</span>
					</a>';
					do_action('nectar_woocommerce_after_filter_trigger');
		echo '</div>';
	}
}

add_filter( 'woocommerce_product_related_products_heading', function( $translated_text ) {
    return 'También podría interesarte...';
});

add_filter('gettext', 'salient_traduce_paginacion', 20, 3);
function salient_traduce_paginacion($translated_text, $text, $domain) {
    if ($text === 'Next') {
        $translated_text = 'Siguiente';
    }
    if ($text === 'Previous') {
        $translated_text = 'Anterior';
    }
    return $translated_text;
}


// Cambiar h2 por h3 en el loop de productos (solo en home)
add_action( 'template_redirect', function() {
    if ( is_front_page() || is_product() ) {
        remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
        add_action( 'woocommerce_shop_loop_item_title', function() {
            echo '<h3 class="woocommerce-loop-product__title">' . get_the_title() . '</h3>';
        }, 10 );
    }
});

?>

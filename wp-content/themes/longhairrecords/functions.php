<?php
/*
 Theme Name:        LongHair Records
 Theme URI:         https://www.longhairrecords.com
 Description:       Divi child theme for the LongHair Records website.
 Tags:              music, entertainment, e-commerce, woocommerce, responsive-design, custom-header, custom-menu, featured-images, threaded-comments, translation-ready, divi-child
 Author:            Richard Bakos @ Resonance Designs
 Author URI:        https://resonancedesigns.dev
 Template:          Divi
 Version:           2.0.3
 Requires at least: 5.0
 Tested up to:      6.8.2
 Requires PHP:      7.4
 License:           GNU General Public License v2 or later
 License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 Text Domain:       longhairrecords
*/

/**
 * Set X-Frame Options
 *
 */
add_action( 'send_headers', 'send_frame_options_header', 10, 0 );

/**
 * Enques styles
 *
 */
function longhairrecords__divi_child_enque_styles() {
    // Enques Divi styles
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', date("h:i:s") );
    // Enques child theme styles
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
    // Enques Font Awesome
    wp_enqueue_style( 'fontawesome-style',
        '//use.fontawesome.com/releases/v5.7.2/css/all.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'longhairrecords__divi_child_enque_styles' );

// Enques admin styles after SB Instagram plugin loads its own style
function my_child_admin_styles() {
    wp_enqueue_style( 'my-child-admin-style', get_stylesheet_directory_uri() . '/admin-styles.css', array( 'sb_instagram_admin_css' ), wp_get_theme()->get( 'Version' ) );
}
add_action( 'admin_enqueue_scripts', 'my_child_admin_styles' );

/**
 * Enqueue custom admin JS
 */
function longhairrecords__enqueue_admin_custom_js($hook) {
    wp_enqueue_script(
        'admin-custom-scripts',
        get_stylesheet_directory_uri() . '/js/admin-custom.js',
        array('jquery'),
        filemtime(get_stylesheet_directory() . '/js/admin-custom.js'), // better cache-busting
        true
    );
}
add_action('admin_enqueue_scripts', 'longhairrecords__enqueue_admin_custom_js');

/**
 * Enques JS
 *
 */
function longhairrecords__divi_child_enque_js() {
    wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), date("h:i:s"), true);
}
add_action( 'wp_enqueue_scripts', 'longhairrecords__divi_child_enque_js' );

/**
 * Declare WooCommerce Support
 *
 */
function longhairrecords_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'longhairrecords_add_woocommerce_support' );

/**
 * Change PayPal Gateway Icon
 *
 */
add_filter( 'woocommerce_paypal_icon', 'lhr_replace_paypal_icon' );
function lhr_replace_paypal_icon() {
	return 'https://longhairrecords.com/wp-content/themes/longhairrecords/imgs/paypal-330x110.png';
}

/**
 * Change the breadcrumb delimeter/separator
 *
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter' );
function wcc_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = ' &#47;&#47; ';
	return $defaults;
}

/**
 * Change default post sorting
 *
 */
function lh_woocommerce_catalog_orderby( $orderby ) {
	// Remove sorting options
	unset($orderby["price"]);
	unset($orderby["price-desc"]);
	unset($orderby["popularity"]);
	unset($orderby["rating"]);
	// Create new price sorting
	$orderby['price-ascd'] = __( 'Sort by price: low to high', 'woocommerce' );
	$orderby['price-desc'] = __( 'Sort by price: high to low', 'woocommerce' );
	return $orderby;
}
add_filter( 'woocommerce_catalog_orderby', 'lh_woocommerce_catalog_orderby', 20 );

/**
 * Add the ability to sort by price
 *
 */
function lh_woocommerce_get_catalog_ordering_args( $args ) {
	$orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
	if ( 'price-ascd' == $orderby_value ) {
		$args['orderby'] = 'price';
		$args['order']   = 'ASC';
	}
	if ( 'price-desc' == $orderby_value ) {
		$args['orderby'] = 'price';
		$args['order']   = 'DESC';
	}
	return $args;
}
add_filter( 'woocommerce_get_catalog_ordering_args', 'lh_woocommerce_get_catalog_ordering_args', 20 );

/**
 * Custom redirect for order confirmation
 *
 */
function lh_redirectcustom( $order_id ){
    $order = wc_get_order( $order_id );
    $url = 'https://longhairrecords.com/thank-you';
    if ( ! $order->has_status( 'failed' ) ) {
        wp_safe_redirect( $url );
        exit;
    }
}
add_action( 'woocommerce_thankyou', 'lh_redirectcustom');

/**
 * Additional Divi settings
 *
 */
if ( ! function_exists( 'et_load_core_options' ) ) {
	function et_load_core_options() {
        global $shortname, $themename;
		require_once get_template_directory() . esc_attr( "/options_{$shortname}.php" );
        $newOptions = [];
        foreach ($options as $i => $optionArray) {
            $newOptions[] = $optionArray;
            // Additional social icon settings
            if (isset($optionArray['id']) && $optionArray['id'] == 'divi_show_google_icon') {
                // Spotify Icon
                $showOptions = array(
                    "name" =>esc_html__( "Show Spotify Icon", $themename ),
                    "id" => $shortname."_show_spotify_icon",
                    "type" => "checkbox2",
                    "std" => "on",
                    "desc" =>esc_html__( "Here you can choose to display the Spotify Icon. ", $themename ) );
                $newOptions[] = $showOptions;
                // Youtube icon
                $showOptions2 = array(
                    "name" =>esc_html__( "Show Youtube Icon", $themename ),
                    "id" => $shortname."_show_youtube_icon",
                    "type" => "checkbox2",
                    "std" => "on",
                    "desc" =>esc_html__( "Here you can choose to display the Youtube Icon. ", $themename ) );
                $newOptions[] = $showOptions2;
                // Soundcloud icon
                $showOptions3 = array(
                    "name" =>esc_html__( "Show Soundcloud Icon", $themename ),
                    "id" => $shortname."_show_soundcloud_icon",
                    "type" => "checkbox2",
                    "std" => "on",
                    "desc" =>esc_html__( "Here you can choose to display the Soundcloud Icon. ", $themename ) );
                $newOptions[] = $showOptions3;
                // Google Play icon
                $showOptions4 = array(
                    "name" =>esc_html__( "Show Google Play Icon", $themename ),
                    "id" => $shortname."_show_googleplay_icon",
                    "type" => "checkbox2",
                    "std" => "on",
                    "desc" =>esc_html__( "Here you can choose to display the Google Play Icon. ", $themename ) );
                $newOptions[] = $showOptions4;
                // iTunes icon
                $showOptions5 = array(
                    "name" =>esc_html__( "Show iTunes Icon", $themename ),
                    "id" => $shortname."_show_itunes_icon",
                    "type" => "checkbox2",
                    "std" => "on",
                    "desc" =>esc_html__( "Here you can choose to display the iTunes Icon. ", $themename ) );
                $newOptions[] = $showOptions5;
                // iTunes Podcast icon
                $showOptions6 = array(
                    "name" =>esc_html__( "Show iTunes Podcast Icon", $themename ),
                    "id" => $shortname."_show_itunes_podcast_icon",
                    "type" => "checkbox2",
                    "std" => "on",
                    "desc" =>esc_html__( "Here you can choose to display the iTunes Podcast Icon. ", $themename ) );
                $newOptions[] = $showOptions6;
                // Stitcher icon
                $showOptions7 = array(
                    "name" =>esc_html__( "Show Stitcher Icon", $themename ),
                    "id" => $shortname."_show_stitcher_icon",
                    "type" => "checkbox2",
                    "std" => "on",
                    "desc" =>esc_html__( "Here you can choose to display the Stitcher Icon. ", $themename ) );
                $newOptions[] = $showOptions7;
            }
            // Additional social URL options
            if (isset($optionArray['id']) && $optionArray['id'] == 'divi_google_url') {
                // Spotify URL
                $urlOptions = array(
                    "name" =>esc_html__( "Spotify Page Url", $themename ),
                    "id" => $shortname."_spotify_url",
                    "std" => "#",
                    "type" => "text",
                    "validation_type" => "url",
                    "desc" =>esc_html__( "Enter the URL of your Spotify page. ", $themename ) );
                $newOptions[] = $urlOptions;
                // Youtube URL
                $urlOptions2 = array(
                    "name" =>esc_html__( "Youtube Url", $themename ),
                    "id" => $shortname."_youtube_url",
                    "std" => "#",
                    "type" => "text",
                    "validation_type" => "url",
                    "desc" =>esc_html__( "Enter the URL of your Youtube Channel. ", $themename ) );
                $newOptions[] = $urlOptions2;
                // Soundcloud URL
                $urlOptions3 = array(
                    "name" =>esc_html__( "Soundcloud Url", $themename ),
                    "id" => $shortname."_soundcloud_url",
                    "std" => "#",
                    "type" => "text",
                    "validation_type" => "url",
                    "desc" =>esc_html__( "Enter the URL of your Soundcloud page. ", $themename ) );
                $newOptions[] = $urlOptions3;
                // Google Play URL
                $urlOptions4 = array(
                    "name" =>esc_html__( "Google Play Url", $themename ),
                    "id" => $shortname."_googleplay_url",
                    "std" => "#",
                    "type" => "text",
                    "validation_type" => "url",
                    "desc" =>esc_html__( "Enter the URL of your Google Play profile. ", $themename ) );
                $newOptions[] = $urlOptions4;
                // iTunes URL
                $urlOptions5 = array(
                    "name" =>esc_html__( "iTunes Url", $themename ),
                    "id" => $shortname."_itunes_url",
                    "std" => "#",
                    "type" => "text",
                    "validation_type" => "url",
                    "desc" =>esc_html__( "Enter the URL of your iTunes page. ", $themename ) );
                $newOptions[] = $urlOptions5;
                // iTunes Podcast URL
                $urlOptions6 = array(
                    "name" =>esc_html__( "iTunes Podcast Url", $themename ),
                    "id" => $shortname."_itunes_podcast_url",
                    "std" => "#",
                    "type" => "text",
                    "validation_type" => "url",
                    "desc" =>esc_html__( "Enter the URL of your iTunes podcast page. ", $themename ) );
                $newOptions[] = $urlOptions6;
                // Stitcher URL
                $urlOptions7 = array(
                    "name" =>esc_html__( "Stitcher Url", $themename ),
                    "id" => $shortname."_stitcher_url",
                    "std" => "#",
                    "type" => "text",
                    "validation_type" => "url",
                    "desc" =>esc_html__( "Enter the URL of your Stitcher profile. ", $themename ) );
                $newOptions[] = $urlOptions7;
			}
		}
		$options = $newOptions;
	}
}

/**
 * Custom MIME types
 *
 */
function my_custom_mime_types( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['ttf'] = 'application/x-font-ttf';
    $mimes['otf'] = 'application/x-font-opentype';
    $mimes['woff'] = 'application/font-woff';
    $mimes['woff2'] = 'application/font-woff2';
    $mimes['eot'] = 'application/vnd.ms-fontobject';
    $mimes['sfnt'] = 'application/font-sfnt';
    return $mimes;
}
add_filter('upload_mimes', 'my_custom_mime_types');

/**
 * Only import in-stock items (tracked > 0) or untracked (null) from Square.
 */
function lhr_square_import_only_instock( $data, $catalog_object, $job = null ) {
    try {
        if ( ! ( $catalog_object instanceof \Square\Models\CatalogObject ) || ! $catalog_object->getItemData() ) {
            return $data;
        }

        $variations = $catalog_object->getItemData()->getVariations() ? $catalog_object->getItemData()->getVariations() : array();
        if ( empty( $variations ) ) {
            return $data;
        }

        $location_id   = wc_square()->get_settings_handler()->get_location_id();
        $variation_ids = array();
        $any_not_tracked = false;

        foreach ( $variations as $variation ) {
            if ( ! ( $variation instanceof \Square\Models\CatalogObject ) || ! $variation->getItemVariationData() ) {
                continue;
            }

            // Respect location availability like the importer does.
            if ( is_array( $variation->getAbsentAtLocationIds() ) && in_array( $location_id, $variation->getAbsentAtLocationIds(), true ) ) {
                continue;
            }
            if ( ! $variation->getPresentAtAllLocations() && ( ! is_array( $variation->getPresentAtLocationIds() ) || ! in_array( $location_id, $variation->getPresentAtLocationIds(), true ) ) ) {
                continue;
            }

            $track_inventory = $variation->getItemVariationData()->getTrackInventory();

            // Location overrides can change tracking per location.
            $overrides = $variation->getItemVariationData()->getLocationOverrides();
            if ( is_array( $overrides ) && ! empty( $overrides ) ) {
                foreach ( $overrides as $override ) {
                    if ( $override->getLocationId() === $location_id && null !== $override->getTrackInventory() ) {
                        $track_inventory = $override->getTrackInventory();
                        break;
                    }
                }
            }

            if ( ! $track_inventory ) {
                $any_not_tracked = true; // Allowed (null stock).
            } else {
                $variation_ids[] = $variation->getId();
            }
        }

        // If any variation is untracked, allow import.
        if ( $any_not_tracked ) {
            return $data;
        }

        if ( ! empty( $variation_ids ) ) {
            $result = wc_square()->get_api()->batch_retrieve_inventory_counts( array(
                'catalog_object_ids' => $variation_ids,
                'location_ids'       => array( $location_id ),
                'states'             => array( 'IN_STOCK' ),
            ) );

            $has_in_stock = false;
            if ( method_exists( $result, 'get_counts' ) ) {
                foreach ( $result->get_counts() as $inventory_count ) {
                    $qty = (float) $inventory_count->getQuantity();
                    if ( $qty > 0 ) {
                        $has_in_stock = true;
                        break;
                    }
                }
            }

            // If all tracked variations are zero at this location, keep product as draft/hidden.
            if ( ! $has_in_stock ) {
                $data['status']             = 'draft';
                $data['catalog_visibility'] = 'hidden';
            }
        }
    } catch ( \Throwable $e ) {
        // Fail open: don't block import in case of API errors.
        return $data;
    }

    return $data;
}
add_filter( 'woocommerce_square_create_product_data', 'lhr_square_import_only_instock', 20, 3 );

/**
 * Set imported WooCommerce products with no image to Draft status.
 *
 * @param WC_Product $product The product object.
 * @return WC_Product Modified product object.
 */
function custom_set_imported_products_to_draft_if_no_image( $product ) {
    // Check if the product has a featured image (thumbnail).
    if ( ! $product->get_image_id() ) {
        // If no image, set the product status to 'draft'.
        $product->set_status( 'draft' );
    }
    return $product;
}
add_filter( 'woocommerce_product_import_inserted_product_object', 'custom_set_imported_products_to_draft_if_no_image', 10, 1 );

/**
 * Sidebar Customization
 *
 */
function et_single_settings_meta_box( $post ) {
	$post_id = get_the_ID();

	wp_nonce_field( basename( __FILE__ ), 'et_settings_nonce' );

	$page_layout = get_post_meta( $post_id, '_et_pb_page_layout', true );

	$side_nav = get_post_meta( $post_id, '_et_pb_side_nav', true );

	$selected_sidebar = get_post_meta( $post_id, '_et_pb_sidebar_figarts', true );

	$project_nav = get_post_meta( $post_id, '_et_pb_project_nav', true );

	$post_hide_nav = get_post_meta( $post_id, '_et_pb_post_hide_nav', true );
	$post_hide_nav = $post_hide_nav && 'off' === $post_hide_nav ? 'default' : $post_hide_nav;

	$show_title = get_post_meta( $post_id, '_et_pb_show_title', true );

	$page_layouts = array(
		'et_right_sidebar'   => esc_html__( 'Right Sidebar', 'Divi' ),
		'et_left_sidebar'    => esc_html__( 'Left Sidebar', 'Divi' ),
		'et_full_width_page' => esc_html__( 'Full Width', 'Divi' ),
	);

	$sidebars = allsidebars();

	$layouts = array(
		'light' => esc_html__( 'Light', 'Divi' ),
		'dark'  => esc_html__( 'Dark', 'Divi' ),
	);
	$post_bg_color  = ( $bg_color = get_post_meta( $post_id, '_et_post_bg_color', true ) ) && '' !== $bg_color
		? $bg_color
		: '#ffffff';
	$post_use_bg_color = get_post_meta( $post_id, '_et_post_use_bg_color', true )
		? true
		: false;
	$post_bg_layout = ( $layout = get_post_meta( $post_id, '_et_post_bg_layout', true ) ) && '' !== $layout
		? $layout
		: 'light'; ?>

	<p class="et_pb_page_settings et_pb_page_layout_settings">
		<label for="et_pb_page_layout" style="display: block; font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Page Layout', 'Divi' ); ?>: </label>

		<select id="et_pb_page_layout" name="et_pb_page_layout">
		<?php
		foreach ( $page_layouts as $layout_value => $layout_name ) {
			printf( '<option value="%2$s"%3$s>%1$s</option>',
				esc_html( $layout_name ),
				esc_attr( $layout_value ),
				selected( $layout_value, $page_layout, false )
			);
		} ?>
		</select>
	</p>
	<p class="et_pb_page_settings et_pb_side_nav_settings" style="display: none;">
		<label for="et_pb_side_nav" style="display: block; font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Dot Navigation', 'Divi' ); ?>: </label>

		<select id="et_pb_side_nav" name="et_pb_side_nav">
			<option value="off" <?php selected( 'off', $side_nav ); ?>><?php esc_html_e( 'Off', 'Divi' ); ?></option>
			<option value="on" <?php selected( 'on', $side_nav ); ?>><?php esc_html_e( 'On', 'Divi' ); ?></option>
		</select>
	</p>
	<p class="et_pb_page_settings">
		<label for="et_pb_post_hide_nav" style="display: block; font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Hide Nav Before Scroll', 'Divi' ); ?>: </label>

		<select id="et_pb_post_hide_nav" name="et_pb_post_hide_nav">
			<option value="default" <?php selected( 'default', $post_hide_nav ); ?>><?php esc_html_e( 'Default', 'Divi' ); ?></option>
			<option value="no" <?php selected( 'no', $post_hide_nav ); ?>><?php esc_html_e( 'Off', 'Divi' ); ?></option>
			<option value="on" <?php selected( 'on', $post_hide_nav ); ?>><?php esc_html_e( 'On', 'Divi' ); ?></option>
		</select>
	</p>

	<p class="et_pb_page_settings">
		<label for="_et_pb_sidebar_figarts" style="display: block; font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Sidebar', 'Divi' ); ?>: </label>
		<select id="_et_pb_sidebar_figarts" name="_et_pb_sidebar_figarts">
			<?php $wp_registered_sidebars = allsidebars(); ?>
			<?php foreach ( $wp_registered_sidebars as $sidebar ) : ?>
				<option value="<?php echo $sidebar['id']; ?>" <?php selected( $sidebar['id'], $selected_sidebar ); ?>><?php esc_html_e( $sidebar['name'], 'Divi' ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>

	<?php if ( 'post' === $post->post_type ) : ?>
		<p class="et_pb_page_settings et_pb_single_title" style="display: none;">
			<label for="et_single_title" style="display: block; font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Post Title', 'Divi' ); ?>: </label>

			<select id="et_single_title" name="et_single_title">
				<option value="on" <?php selected( 'on', $show_title ); ?>><?php esc_html_e( 'Show', 'Divi' ); ?></option>
				<option value="off" <?php selected( 'off', $show_title ); ?>><?php esc_html_e( 'Hide', 'Divi' ); ?></option>
			</select>
		</p>

		<p class="et_divi_quote_settings et_divi_audio_settings et_divi_link_settings et_divi_format_setting et_pb_page_settings">
			<label for="et_post_use_bg_color" style="display: block; font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Use Background Color', 'Divi' ); ?></label>
			<input name="et_post_use_bg_color" type="checkbox" id="et_post_use_bg_color" <?php checked( $post_use_bg_color ); ?> />
		</p>

		<p class="et_post_bg_color_setting et_divi_format_setting et_pb_page_settings">
			<input id="et_post_bg_color" name="et_post_bg_color" class="color-picker-hex" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value', 'Divi' ); ?>" value="<?php echo esc_attr( $post_bg_color ); ?>" data-default-color="#ffffff" />
		</p>

		<p class="et_divi_quote_settings et_divi_audio_settings et_divi_link_settings et_divi_format_setting">
			<label for="et_post_bg_layout" style="font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Text Color', 'Divi' ); ?>: </label>
			<select id="et_post_bg_layout" name="et_post_bg_layout">
		<?php
			foreach ( $layouts as $layout_name => $layout_title )
				printf( '<option value="%s"%s>%s</option>',
					esc_attr( $layout_name ),
					selected( $layout_name, $post_bg_layout, false ),
					esc_html( $layout_title )
				);
		?>
			</select>
		</p>
	<?php endif;
}

function allsidebars() {
    global $wp_registered_sidebars;
    if ( !empty( $wp_registered_sidebars ) )
        return $wp_registered_sidebars;
}
add_action('init', 'allsidebars');

function figarts_divi_post_settings_save_details( $post_id, $post ){
	global $pagenow;

	if ( 'post.php' != $pagenow ) return $post_id;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	if ( ! isset( $_POST['et_settings_nonce'] ) || ! wp_verify_nonce( $_POST['et_settings_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	if ( isset( $_POST['_et_pb_sidebar_figarts'] ) )
		update_post_meta( $post_id, '_et_pb_sidebar_figarts', sanitize_text_field( $_POST['_et_pb_sidebar_figarts'] ) );
	 else
			delete_post_meta( $post_id, '_et_pb_sidebar_figarts' );

}
add_action( 'save_post', 'figarts_divi_post_settings_save_details', 10, 2 );

/**
 * Restore custom archive header (title + description) via hook,
 * without overriding archive-product.php.
 */
add_action( 'woocommerce_shop_loop_header', function() {
    // Output the page title.
    if ( apply_filters( 'woocommerce_show_page_title', true ) ) {
        echo '<h1 class="woocommerce-products-header__title page-title">';
        woocommerce_page_title();
        echo '</h1>';
    }

    // Output archive description (taxonomy or shop page content).
    do_action( 'woocommerce_archive_description' );
}, 20 ); // Run after WooCommerce's default header (priority 10).

/**
 * Add search form to single product pages
 * Moved from single-product.php template to functions.php for better maintainability
 */
function lhr_add_search_form_to_single_product() {
    // Only show on single product pages
    if (is_product()) {
        echo do_shortcode('[aws_search_form id="2"]');
    }
}
add_action('woocommerce_before_main_content', 'lhr_add_search_form_to_single_product', 25);

/**
 * Add sidebar to WooCommerce single product pages
 * Uses the woocommerce_sidebar action hook for proper integration
 */
function lhr_add_product_sidebar() {
    static $sidebar_rendered = false;

    if (is_product() && !$sidebar_rendered) {
        // Include the entire sidebar-store.php file
        get_template_part('sidebar', 'store');
        $sidebar_rendered = true;
    }
}
add_action('woocommerce_sidebar', 'lhr_add_product_sidebar');

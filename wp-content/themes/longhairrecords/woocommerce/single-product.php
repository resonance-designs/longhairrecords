n<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

/**
 * Template customizations:
 * - Add a breadcrumb trail using WooCommerce Breadcrumbs function
 * - Add an advanced search form from Advanced WooSearch plugin
 * - Remove the page title and add product name instead
 * - Change the background color of the separator line between breadcrumbs and product title
 *
 * @author      Richard Bakos @ Resonance Designs <info@resonancedesigns.dev>
 * @copyright   Copyright © 2019-2025 Richard Bakos @ Resonance Designs
 * @link        https://resonancedesigns.dev Author's Website
 * @link        https://github.com/resonance-designs Author's GitHub Profile
 * @link        https://github.com/resonance-designs/longhairrecords GitHub Repository
 * @link        https://longhairrecords.com LongHair Records
 * @package     LongHairRecords\Templates
 * @version     2.1.2
 * @since       2.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );
?>
<div id="et-main-area">
    <div id="main-content">
        <div class="container">
            <div id="content-area" class="clearfix">

                <div id="page-info">
                    <?php echo woocommerce_breadcrumb(); ?>
                    <?php echo do_shortcode('[aws_search_form id="2"]'); ?>
                    <div class="et_pb_row et_pb_row_6">
			            <div class="et_pb_column et_pb_column_4_4 et_pb_column_9 et_pb_css_mix_blend_mode_passthrough et-last-child lh-separator"></div>
		            </div>
                    <h1 class="product_title entry-title"><?php echo get_the_title(); ?> - <?php echo $product->get_price_html(); ?></h1>
                </div>

                <div id="left-area">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php wc_get_template_part( 'content', 'single-product' ); ?>
                    <?php endwhile; // end of the loop. ?>
                </div><!-- #left-area -->

                <div id="right-area" class="lh-sidebar">
                    <?php get_template_part( 'sidebar', 'store' ); ?>
                </div><!-- #right-area -->

            </div><!-- #content-area -->
        </div><!-- .container -->
    </div><!-- #main-content -->
</div><!-- #et-main-area -->

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

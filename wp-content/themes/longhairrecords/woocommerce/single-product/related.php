<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     10.3.0
 */

/**
 * Template customization:
 * - Remove "You may also like..." heading
 * - Add custom background color between section title and product grid
 * - Increase content media count to omit lazy loading attribute from related products
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
	exit;
}

if ( $related_products ) :
	/**
	 * Ensure all images of related products are lazy loaded by increasing the
	 * current media count to WordPress's lazy loading threshold if needed.
	 * Because wp_increase_content_media_count() is a private function, we
	 * check for its existence before use.
	 */
	if ( function_exists( 'wp_increase_content_media_count' ) ) {
		$content_media_count = wp_increase_content_media_count( 0 );
		if ( $content_media_count < wp_omit_loading_attr_threshold() ) {
			wp_increase_content_media_count( wp_omit_loading_attr_threshold() - $content_media_count );
		}
	}
	?>

	<section class="related products">
        <div class="et_pb_row et_pb_row_6">
			<div class="et_pb_column et_pb_column_4_4 et_pb_column_9  et_pb_css_mix_blend_mode_passthrough et-last-child" style="background: #f7921e;height: 2px;"></div>
		</div>
		<?php
		    $heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );
		    if ( $heading ) :
		?>
		<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

					<?php
					$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part( 'content', 'product' );
					?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>
	<?php
endif;

wp_reset_postdata();

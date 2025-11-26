<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.7.0
 */

/**
 * Template customization:
 * - Remove product meta from single products
 * - Add custom meta data for each product type
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

use Automattic\WooCommerce\Enums\ProductType;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>

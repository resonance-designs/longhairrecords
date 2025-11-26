<?php
/**
 * Sidebar
 *
 * Custom side-bar template.
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

if ( ( is_single() || is_page() ) && 'et_full_width_page' === get_post_meta( get_queried_object_id(), '_et_pb_page_layout', true ) )
	return;

$sidebar = get_post_meta( get_the_ID(), '_et_pb_sidebar_figarts', true );

if ( is_active_sidebar( $sidebar ) ) : ?>
	<div id="sidebar">
		<?php dynamic_sidebar( $sidebar ); ?>
	</div> <!-- end #sidebar -->
<?php endif; ?>
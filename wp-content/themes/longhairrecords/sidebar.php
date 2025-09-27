<?php
/*
 Theme Name:        LongHair Records
 Theme URI:         https://www.longhairrecords.com
 Description:       Divi child theme for the LongHair Records website.
 Tags:              music, entertainment, e-commerce, woocommerce, responsive-design, custom-header, custom-menu, featured-images, threaded-comments, translation-ready, divi-child
 Author:            Richard Bakos @ Resonance Designs
 Author URI:        https://resonancedesigns.dev
 Template:          Divi
 Version:           2.0.0
 Requires at least: 5.0
 Tested up to:      6.7
 Requires PHP:      7.4
 License:           GNU General Public License v2 or later
 License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 Text Domain:       longhairrecords
*/

if ( ( is_single() || is_page() ) && 'et_full_width_page' === get_post_meta( get_queried_object_id(), '_et_pb_page_layout', true ) )
	return;

$sidebar = get_post_meta( get_the_ID(), '_et_pb_sidebar_figarts', true );

if ( is_active_sidebar( $sidebar ) ) : ?>
	<div id="sidebar">
		<?php dynamic_sidebar( $sidebar ); ?>
	</div> <!-- end #sidebar -->
<?php endif; ?>
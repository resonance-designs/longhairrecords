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

/**
 * Account Sidebar
 *
 * Custom side-bar for use on account pages
 */
?>

<div id="sidebar">
    <div class="et_pb_module et_pb_image et_pb_image_0 lh-image-container" style="margin-bottom: 20px;">
        <a href="https://longhairrecords.com/wp-content/uploads/2019/04/grading-policy.png" class="et_pb_lightbox_image" title="">
            <span class="et_pb_image_wrap ">
                <img src="https://longhairrecords.com/wp-content/uploads/2019/04/grading-policy.png" alt="" title="">
            </span>
        </a>
	</div>
    <?php dynamic_sidebar( 'Account - Right Sidebar' ); ?>
</div>
<?php

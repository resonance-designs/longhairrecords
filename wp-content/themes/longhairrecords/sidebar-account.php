<?php
/**
 * Account Sidebar
 *
 * Custom side-bar for use on account pages
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

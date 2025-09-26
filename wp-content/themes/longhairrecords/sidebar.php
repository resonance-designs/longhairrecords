<?php
if ( ( is_single() || is_page() ) && 'et_full_width_page' === get_post_meta( get_queried_object_id(), '_et_pb_page_layout', true ) )
	return;

$sidebar = get_post_meta( get_the_ID(), '_et_pb_sidebar_figarts', true );

if ( is_active_sidebar( $sidebar ) ) : ?>
	<div id="sidebar">
		<?php dynamic_sidebar( $sidebar ); ?>
	</div> <!-- end #sidebar -->
<?php endif; ?>
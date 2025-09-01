<ul class="et-social-icons">
<?php /* Facebook */ if ( 'on' === et_get_option( 'divi_show_facebook_icon', 'on' ) ) : ?>
	<li class="et-social-icon rm-social-facebook">
		<a href="<?php echo esc_url( et_get_option( 'divi_facebook_url', '#' ) ); ?>" class="icon">
			<i class="fab fa-facebook-f"></i>
		</a>
	</li>
<?php endif; ?>
<?php /* Twitter */ if ( 'on' === et_get_option( 'divi_show_twitter_icon', 'on' ) ) : ?>
	<li class="et-social-icon rm-social-twitter">
		<a href="<?php echo esc_url( et_get_option( 'divi_twitter_url', '#' ) ); ?>" class="icon">
			<i class="fab fa-twitter"></i>
		</a>
	</li>
<?php endif; ?>
<?php  /* Google + */ if ( 'on' === et_get_option( 'divi_show_google_icon', 'on' ) ) : ?>
	<li class="et-social-icon rm-social-google-plus">
		<a href="<?php echo esc_url( et_get_option( 'divi_google_url', '#' ) ); ?>" class="icon">
			<i class="fab fa-google-plus-g"></i>
		</a>
	</li>
<?php endif; ?>
<?php /* RSS Feed */ if ( 'on' === et_get_option( 'divi_show_rss_icon', 'on' ) ) : ?>
<?php
	$et_rss_url = '' !== et_get_option( 'divi_rss_url' )
		? et_get_option( 'divi_rss_url' )
		: get_bloginfo( 'rss2_url' );
?>
	<li class="et-social-icon rm-social-rss">
		<a href="<?php echo esc_url( $et_rss_url ); ?>" class="icon">
			<i class="fas fa-rss"></i>
		</a>
	</li>
<?php endif; ?>
</ul>
<ul class="share-social-icons clearfix">
	<li>
		<a class="share-ico ico-facebook" target="_blank" href="//www.facebook.com/sharer.php?u=<?php echo esc_url( get_the_permalink() ); ?>">
			<i class="fa fa-facebook" aria-hidden="true"></i>
		</a>
	</li>
	<li>
		<a class="share-ico ico-twitter" target="_blank" href="//twitter.com/share?url=<?php echo esc_url( get_the_permalink() ); ?>&amp;text=<?php echo urlencode( get_the_title() ); ?>">
			<i class="fa fa-twitter" aria-hidden="true"></i>
		</a>
	</li>
	<li>
		<a class="share-ico ico-pinterest" target="_blank" href="//www.pinterest.com/pin/create/button/?url=<?php echo esc_url( get_the_permalink() ); ?>&amp;media=<?php echo esc_url( get_the_post_thumbnail_url() ); ?>&amp;description=<?php echo urlencode( get_the_title() ); ?>">
			<i class="fab fa-pinterest-p"></i>
		</a>
	</li>
</ul>
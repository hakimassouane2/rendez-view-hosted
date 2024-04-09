<footer class="footer_v2 ova-trans">
		
		<?php if( is_active_sidebar('subcribe') ){ ?>
			<div class="subcribe">
				<?php dynamic_sidebar('subcribe'); ?>	
			</div>
		<?php } ?>
		
		<?php if( is_active_sidebar('logo_white') ){ ?>
			<div class="logo_white">
				<?php dynamic_sidebar('logo_white'); ?>	
			</div>
		<?php } ?>

		<?php if( is_active_sidebar('social') ){ ?>
			<div class="social">
				<?php dynamic_sidebar('social'); ?>	
			</div>
		<?php } ?>

		<?php if( is_active_sidebar('copyright') ){ ?>
			<div class="copyright">
				<?php dynamic_sidebar('copyright'); ?>	
			</div>
		<?php } ?>

</footer>
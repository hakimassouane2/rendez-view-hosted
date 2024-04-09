<?php if( is_active_sidebar('logo_dark') || is_active_sidebar('social') || is_active_sidebar('copyright') ){ ?>

<footer class="footer_default ova-trans">
		
		<?php if( is_active_sidebar('logo_dark') ){ ?>
			<div class="logo">
				<?php dynamic_sidebar('logo_dark'); ?>	
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

<?php } ?>
<footer class="footer_v4 ova-trans">

	<div class="container">
		<div class="row">

			<?php if( is_active_sidebar('info_two') ){ ?>
			<div class="col-sm-4 info_two">
				<?php dynamic_sidebar('info_two'); ?>
			</div>
			<?php } ?>

			<?php if( is_active_sidebar('info_three') ){ ?>
			<div class="col-sm-4 info_three">
				<?php dynamic_sidebar('info_three'); ?>
			</div>
			<?php } ?>

			<?php if( is_active_sidebar('info_four') ){ ?>
			<div class="col-sm-4 info_four">
				<?php dynamic_sidebar('info_four'); ?>
			</div>
			<?php } ?>

			<?php if( is_active_sidebar('social') ){ ?>
			<div class="col-sm-12 text-center social">
				<?php dynamic_sidebar('social'); ?>
			</div>
			<?php } ?>

			<?php if( is_active_sidebar('copyright') ){ ?>
			<div class="col-sm-12 text-center copyright">
				<?php dynamic_sidebar('copyright'); ?>
			</div>
			<?php } ?>

		</div>
	</div>


</footer>
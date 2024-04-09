<footer class="footer_v1 ova-trans" style="background: url('<?php echo esc_url( EM4U_URI.'/assets/img/bg_footer.jpg' ); ?>')">
	
	<div class="bg_cover"></div>

	<div class="wrap_widget">
		<div class="container">
			<div class="row">
				<?php if( is_active_sidebar('category') ){ ?>
					<div class="col-sm-4 category pd_0 pd_l_0">
						<?php dynamic_sidebar('category'); ?>
					</div>
				<?php } ?>

				<?php if( is_active_sidebar('gallery') ){ ?>
					<div class="col-sm-4 gallery pd_0">
						<?php dynamic_sidebar('gallery'); ?>
					</div>
				<?php } ?>

				<?php if( is_active_sidebar('tags') ){ ?>
					<div class="col-sm-4 tags  pd_0 pd_r_0">
						<?php dynamic_sidebar('tags'); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="wrap_bellow">
		<div class="container">
			<div class="row">

				<?php if( is_active_sidebar('social') ){ ?>
				<div class="col-sm-4 social  pd_0 pd_l_0">
					<?php dynamic_sidebar('social'); ?>
				</div>
				<?php } ?>

				<?php if( is_active_sidebar('logo_white') ){ ?>
				<div class="col-sm-4 pd_0 logo_white">
					<?php dynamic_sidebar('logo_white'); ?>
				</div>
				<?php } ?>

				<?php if( is_active_sidebar('copyright') ){ ?>
				<div class="col-sm-4 copyright  pd_0 pd_r_0">
					<?php dynamic_sidebar('copyright'); ?>
				</div>
				<?php } ?>

			</div>
		</div>
	</div>

</footer>
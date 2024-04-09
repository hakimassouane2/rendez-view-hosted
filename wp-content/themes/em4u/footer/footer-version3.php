<footer class="footer_v3 ova-trans">
	
	<div class="wrap_top">
		<div class="container">
			<div class="row">
				<?php if( is_active_sidebar('subcribe') ){ ?>
					<div class="subcribe">
						<?php dynamic_sidebar('subcribe'); ?>	
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="wrap_widget">
		<div class="container">
			<div class="row">

				<?php if( is_active_sidebar('info_one') ){ ?>
					<div class="col-md-4 col-sm-12 info_one pd_0 pd_l_0">
						<?php dynamic_sidebar('info_one'); ?>
					</div>
				<?php } ?>


				<?php if( is_active_sidebar('category') ){ ?>
					<div class="col-md-4 col-sm-12 pd_0">
						<div class="category">
							<?php dynamic_sidebar('category'); ?>
						</div>
					</div>
				<?php } ?>

				

				<?php if( is_active_sidebar('tags') ){ ?>
					<div class="col-md-4 col-sm-12 tags pd_0 pd_r_0">
						<?php dynamic_sidebar('tags'); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="wrap_bellow">
		<div class="container">
			<div class="row">

				<?php if( is_active_sidebar('copyright') ){ ?>
				<div class="col-md-6 col-sm-12 copyright pd_0 pd_l_0">
					<?php dynamic_sidebar('copyright'); ?>
				</div>
				<?php } ?>

				<?php if( is_active_sidebar('social') ){ ?>
				<div class="col-md-6 col-sm-12 social pd_0 pd_r_0">
					<?php dynamic_sidebar('social'); ?>
				</div>
				<?php } ?>


				
				

			</div>
		</div>
	</div>

</footer>
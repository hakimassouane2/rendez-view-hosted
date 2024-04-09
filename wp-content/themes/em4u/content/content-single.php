<?php $sticky_class = is_sticky()?'sticky':''; ?>

<div class="ovaem_detail_post">
	<article id="post-<?php the_ID(); ?>" <?php post_class('post-wrap '. $sticky_class); ?>  >

		<?php if( has_post_format('audio') && get_post_meta( $post->ID, 'em4u_met_embed_media', 'true' ) != '' ){ ?>
			<?php if( em4u_postformat_audio() ){ ?>
			 <div class="post-media">
	        	<?php em4u_postformat_audio(); /* Display video of post */ ?>
	        	 <?php if(has_category( )){ ?>
		            <span class="post-categories">
		                <?php the_category('&nbsp;&nbsp;'); ?>
		            </span>
		        <?php } ?>
	        </div>
	        <?php } ?>

		<?php }elseif(has_post_format('gallery')){ ?>

		<?php if(  has_post_format('gallery') && get_post_meta( $post->ID, 'em4u_met_file_list', 'true' ) != ''  ){   ?>
			<div class="post-media">
				<?php em4u_content_gallery(); /* Display gallery of post */ ?>
				 <?php if( has_category( ) ){ ?>
		            <span class="post-categories">
		                <?php the_category('&nbsp;&nbsp;'); ?>
		            </span>
		        <?php } ?>
	        </div>
	    <?php } ?>    

		<?php }elseif( has_post_format('video') && get_post_meta( $post->ID, 'em4u_met_embed_media', 'true' ) != '' ) { ?>

		
			 <div class="post-media">
	        	<?php em4u_postformat_video(); /* Display video of post */ ?>
	        	 <?php if(has_category( )){ ?>
		            <span class="post-categories">
		                <?php the_category('&nbsp;&nbsp;'); ?>
		            </span>
		        <?php } ?>
	        </div>
	    

		<?php }elseif(has_post_thumbnail()){ ?>

	        <div class="post-media">
	        	<?php em4u_content_thumbnail('full'); /* Display thumbnail of post */ ?>
	        	 <?php if( ( has_post_thumbnail()  && ! post_password_required() || has_post_format( 'image') ) &&  has_category( )){ ?>
		            <span class="post-categories">
		                <?php the_category('&nbsp;&nbsp;'); ?>
		            </span>
		        <?php } ?>
	        </div>

        <?php } ?>

      

	    <div class="post-meta">
        	<?php em4u_content_meta(); /* Display Date, Comment */ ?>
	    </div>

	    <div class="post-body">
	    	<div class="post-excerpt">
	            <?php
	            if ( get_the_content() ) {
	            	the_content();
	            }
	            wp_link_pages(); /* Display content of post or intro in category page */ ?>
	        </div>
	    </div>

	    <?php if( has_tag() || has_filter('em4u_content_social') ): ?>
	    	<?php if( !has_filter('em4u_content_social') ){ 
	    		$col = "col-md-12";
	    	}else{
	    		$col = "col-md-7";
	    	}
	    	?>
		    <div class="tags_share">
		    	<div class="row">
		    		<div class="<?php echo esc_attr($col); ?>">
		    			<?php if( has_tag() ): ?>
			    			<div class="tag">
			    				<div class="ovaem_tags">
									<i class="icon_tags_alt"></i>
									<span><?php esc_html_e( 'Tags:', 'em4u' ) ?></span>
									<?php the_tags('','&nbsp;&nbsp;',''); ?>

								</div>
			    			</div>
		    			<?php endif; ?>
		    		</div>
		    		<div class="col-md-5">

		    			<div class="share">
		    				<?php apply_filters( 'em4u_content_social', 10 ); ?>
		    			</div>
		    		</div>
		    	</div>
		    	
		    </div>

		<?php endif; ?>

	</article>	
</div>
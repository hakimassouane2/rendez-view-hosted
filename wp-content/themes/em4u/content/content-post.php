<?php $sticky_class = is_sticky()?'sticky':''; ?>

<?php if( has_post_format('link') ){ ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-wrap '. $sticky_class); ?>  >
		
			<?php
			        $link = get_post_meta( $post->ID, 'format_link_url', true );
			        $link_description = get_post_meta( $post->ID, 'format_link_description', true );
			        
			        if ( is_single() ) {
			                printf( '<h1 class="entry-title"><a href="%1$s" target="blank">%2$s</a></h1>',
			                        $link,
			                        get_the_title()
			                );
			        } else {
			                printf( '<h2 class="entry-title"><a href="%1$s" target="blank">%2$s</a></h2>',
			                        $link,
			                        get_the_title()
			                );
			        }
			?>
			<?php
			        printf( '<a href="%1$s" target="blank">%2$s</a>',
			                $link,
			                $link_description
			        );
			?>
	</article>

<?php }elseif ( has_post_format('aside') ){ ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-wrap '. $sticky_class); ?>  >
			<div class="post-body">
		           <?php the_content(''); /* Display content  */ ?>
		    </div>
	</article>

<?php }else{ ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-wrap '. $sticky_class); ?>  >
			
			<?php if( has_post_format('audio') && get_post_meta( $post->ID, 'em4u_met_embed_media', 'true' ) != '' ){ ?>

				 <div class="post-media">
		        	<?php em4u_postformat_audio(); /* Display video of post */ ?>
		        </div>

			<?php }elseif(has_post_format('gallery') && get_post_meta( $post->ID, 'em4u_met_file_list', 'true' ) != '' ){ ?>

				<div class="post-media">
					<?php em4u_content_gallery(); /* Display gallery of post */ ?>

					

						<?php if(has_category( )){ ?>
				            <span class="post-categories">
				                <?php the_category('&nbsp;&nbsp;'); ?>
				            </span>
				        <?php } ?>

			        
		        </div>

			<?php }elseif( has_post_format('video') && get_post_meta( $post->ID, 'em4u_met_embed_media', 'true' ) != '' ){ ?>

				 <div class="post-media">
		        	<?php em4u_postformat_video(); /* Display video of post */ ?>

		        	<?php if(has_category( )){ ?>
			            <span class="post-categories">
			                <?php the_category('&nbsp;&nbsp;'); ?>
			            </span>
			        <?php } ?>
		        </div>

			<?php }elseif(has_post_thumbnail() ){ ?>

				<div class="post-media">
					<a href="<?php the_permalink(); ?>">
						<?php em4u_content_thumbnail('full'); /* Display thumbnail of post */ ?>
					</a>
					<?php if( ( has_post_thumbnail()  && ! post_password_required() || has_post_format( 'image') ) && has_category( )){ ?>
						<span class="post-categories">
							<?php the_category('&nbsp;&nbsp;'); ?>
						</span>
					<?php } ?>
				</div>

	        <?php } ?>




	        <div class="post-title">
		            <?php em4u_content_title(); /* Display title of post */ ?>
		    </div>

		    <div class="post-body">
		    	<div class="post-excerpt">
		            <?php em4u_content_body(); /* Display content of post or intro in category page */ ?>
		        </div>
		    </div>

	        <div class="post-meta row">
	        	<div class="col-md-8 col-sm-8 left_side">
	        		<?php em4u_content_meta(); /* Display Date, Comment */ ?>
	        	</div>
	        	<div class="col-md-4 col-sm-4 right_side">
	        		<div class="row">
		        		<?php if(!is_single()){ ?> 
				            <?php em4u_content_readmore(); /* Display read more button in category page */ ?>
				    	<?php }?>	
			    	</div>
	        	</div>
		        
		        
		    </div>

		    

		    <?php if(is_single()){ ?>
		    <?php em4u_content_tag(); /* Display tags, category */ ?>
		    <?php } ?>

	</article>


<?php } ?>
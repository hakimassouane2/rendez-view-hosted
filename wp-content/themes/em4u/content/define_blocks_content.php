<?php

/* This is functions define blocks to display post */

if ( ! function_exists( 'em4u_content_thumbnail' ) ) {
  function em4u_content_thumbnail( $size ) {
    if ( has_post_thumbnail()  && ! post_password_required() || has_post_format( 'image') )  :
      the_post_thumbnail( $size, array('class'=> 'img-responsive' ));
    endif;
  }
}

if ( ! function_exists( 'em4u_postformat_video' ) ) {
  function em4u_postformat_video( ) { ?>
    <?php if(has_post_format('video') && wp_oembed_get(get_post_meta(get_the_id(), "em4u_met_embed_media", true))){ ?>
	    <div class="js-video postformat_video">
	        <?php echo wp_oembed_get(get_post_meta(get_the_id(), "em4u_met_embed_media", true)); ?>
	    </div>
    <?php } ?>
  <?php }
}

if ( ! function_exists( 'em4u_postformat_audio ') ) {
  function em4u_postformat_audio( ) { ?>
    <?php if(has_post_format('audio') && wp_oembed_get(get_post_meta(get_the_id(), "em4u_met_embed_media", true))){ ?>
	    <div class="js-video postformat_audio">
	        <?php echo wp_oembed_get(get_post_meta(get_the_id(), "em4u_met_embed_media", true)); ?>
	    </div>
    <?php } ?>
  <?php }
}

if ( ! function_exists( 'em4u_content_title' ) ) {
  function em4u_content_title() { ?>

    <?php if ( is_single() ) : ?>
      <h1 class="post-title">
          <?php the_title(); ?>
      </h1>
    <?php else : ?>
      <h2 class="post-title">
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
          <?php the_title(); ?>
        </a>
      </h2>
      <?php endif; ?>

 <?php }
}


if ( ! function_exists( 'em4u_content_meta' ) ) {
  function em4u_content_meta( ) { ?>
	    <span class="post-meta-content">
		    
		    <span class=" post-date">
		        <span class="left"><i class="icon_calendar"></i></span>
		        <span class="right"><?php the_time( get_option( 'date_format' ));?></span>
		    </span>

		    
		    <span class=" comment">
		        <span class="left"><i class="icon_comment_alt"></i></span>
		        <span class="right"><a href="<?php the_permalink();?>">                    
		            <?php comments_popup_link(
		            	esc_html__(' 0 comments', 'em4u'), 
		            	esc_html__(' 1 comment', 'em4u'), 
		            	' % comments',
		            	'',
                  		esc_html__( 'Comment off', 'em4u' )
		            ); ?>
		        </a></span>                
		    </span>
		</span>
  <?php }
}

if ( ! function_exists( 'em4u_content_body' ) ) {
  function em4u_content_body( ) { ?>
  	<div class="post-excerpt">
		<?php if(is_single()){
		    the_content();
		    wp_link_pages();                
		}else{
			$the_excerpt = get_the_content() ? get_the_excerpt() : '';
			echo esc_html( $the_excerpt );
		}?>
	</div>

	<?php 
	}
}

if ( ! function_exists( 'em4u_content_readmore' ) ) {
  function em4u_content_readmore( ) { ?>
  	<div class="post-footer">
		<div class="post-readmore">
		    <a class="btn btn-theme btn-theme-transparent" href="<?php the_permalink(); ?>"><?php  esc_html_e('Read more', 'em4u'); ?></a>
		</div>
	</div>
 <?php }
}

if ( ! function_exists( 'em4u_content_tag' ) ) {
  function em4u_content_tag( ) { ?>
	
	    <footer class="post-tag">
	        <?php if(has_tag()){ ?>
	            <span class="post-tags">
	            	<span class="ovatags"><?php esc_html_e('Tags: ', 'em4u'); ?></span>
	                <?php the_tags('','&nbsp;&nbsp;',''); ?>
	            </span>
	        <?php } ?>
	        <div class="clearboth"></div>
	        <?php if(has_category( )){ ?>
	            <span class="post-categories">
	            	<span class="ovacats"><?php esc_html_e('Categories: ', 'em4u'); ?></span>
	                <?php the_category('&nbsp;&nbsp;'); ?>
	            </span>
	        <?php } ?>

	        <div class="share_social">
	        	<span class="ova_label"><?php esc_html_e('Share: ', 'em4u'); ?></span>
	        	<?php em4u_content_social(); ?>
	        </div>
	    </footer>
	
 <?php }
}

if ( ! function_exists( 'em4u_content_gallery' ) ) {
 	function em4u_content_gallery( ) {

		

			$gallery = get_post_meta(get_the_ID(), 'em4u_met_file_list', true)?get_post_meta(get_the_ID(), 'em4u_met_file_list', true):'';

		    $k = 0;
		    if($gallery){
		        $i=0;

		        ?>

		        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				  	<?php foreach ($gallery as $key => $value) { ?>
				    	<li data-target="#carousel-example-generic" data-slide-to="<?php echo esc_attr($i); ?>" class="<?php echo ($i==0) ? 'active':''; ?>"></li>
				    <?php $i++; } ?>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
				  	<?php foreach ($gallery as $key => $value) { ?>
					    <div class="item <?php echo esc_attr($k==0)?'active':'';$k++; ?>">
					      <img class="img-responsive" src="<?php  echo esc_attr($value); ?>" alt="<?php echo get_the_title(); ?>">
					    </div>
				   	<?php } ?>
				   </div>

				</div>

		       
		        <?php
		    }
		

	}
}







//Custom comment List:
if ( ! function_exists( 'em4u_theme_comment' ) ) {
function em4u_theme_comment($comment, $args, $depth) {

   $GLOBALS['comment'] = $comment; ?>   
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <article class="comment_item" id="comment-<?php comment_ID(); ?>">
         <header class="comment-author">
         	<?php echo get_avatar($comment,$size='70', $default = 'mysteryman' ); ?>
         </header>

         <section class="comment-details">

         	

            <div class="comment-meta commentmetadata clearfix media-body author-name">
				
					<span class="author"><?php printf('%s', get_comment_author_link()) ?></span>
					<span class="date"><?php printf(get_comment_date()) ?></span>
					<div class="ova_reply">
					    <?php edit_comment_link( __( '&nbsp;(Edit)', 'em4u' ), '  ', '' );?>
					    <span><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
					</div>
				
            </div>

            <div class="comment-body clearfix comment-content">
                <?php comment_text() ?>
            </div>

            
                
             
          </section>
          <?php if ($comment->comment_approved == '0') : ?>
             <em><?php esc_html_e('Your comment is awaiting moderation.', 'em4u') ?></em>
             <br />
          <?php endif; ?>
      
        
     </article>
<?php
}
}
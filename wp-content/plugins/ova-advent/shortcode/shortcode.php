<?php
/* Slideshow Shortcode */


add_shortcode('ova_adevent_main_slider', 'ova_adevent_main_slider');
function ova_adevent_main_slider($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'auto_slider' => 'true',
      'duration'    => '3000',
      'navigation'  => 'true',
      'loop'        => 'true',
      'height_desk' => '680px',
      'height_ipad' => '768px',
      'height_mobile' => '800px',
      'padding_top_desk'	=> '230px',
      'padding_top_ipad'	=> '230px',
      'padding_top_mobile'	=> '230px',
      'class'       => '',
    ), $atts) );
    

    $html = '';
    $html .= '<div class="main_slider main_slider_v1 owl-carousel '.$class.'" data-height_desk="'.$height_desk.'"  data-height_ipad="'.$height_ipad.'" data-height_mobile="'.$height_mobile.'" data-loop="'.$loop.'" data-auto_slider="'.$auto_slider.'" data-duration="'.$duration.'" data-navigation="'.$navigation.'" data-padding_top_desk="'.$padding_top_desk.'" data-padding_top_ipad="'.$padding_top_ipad.'" data-padding_top_mobile="'.$padding_top_mobile.'" >';
    
    $html .= do_shortcode($content);

    $html .= '</div>';

    
    return $html;
}



add_shortcode('ova_adevent_main_slider_item', 'ova_adevent_main_slider_item');
function ova_adevent_main_slider_item($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'img'  => '',
      'date'    => '',
      'address'       => '',
      'title'       => '',
      'sub_title' => '',
      'button_text'    => '',
      'button_link'  => '',
      'target_link' => '_self',
      'cover_bg'     => 'true',
      'show_countdown'     => 'no',
      'day' => '',
      'month' => '',
      'year'  => '',
      'hour'  => '',
      'minute' => '',
      'timezone' => '',
      'class'       => '',
    ), $atts) );

    

   

    $img = wp_get_attachment_url( $img, 'full' ) ? wp_get_attachment_url( $img, 'full' ) : '';
    
    $timezone_string = get_option('timezone_string') ;
    

    $html = '<div class="item text-center '.$class.'" style="background-image: url('.$img.')" data-speed="10">';

                    $html .= ($cover_bg == 'true') ? '<div class="cover_bg"></div>':'';

                    $html.= '<div class="caption">
                                <div class="container">
                                    <div class="div-table">
                                        <div class="div-cell">';

                                           $html .= '<div class="slider_date">';
                                           	
                                           	$html .= $date ? '<div class="box"><i class="icon_calendar"></i> <span>'.$date.'</span></div>' : '';

                                           	$html .= $address ? '<div class="box"><i class="icon_pin_alt"></i> <span>'.$address.'</span></div>' : '';

                                           $html .= '</div>';

                                           $html .= $title ? '<h2 class="title">'.$title.'</h2>' : '';

                                           $html .= $sub_title ? '<h3 class="sub_title">'.$sub_title.'</h3>' : '';

                                           $html .= $button_text ? '<div class="ova_button"><a target="'.$target_link.'" class="ova-btn ova-btn-rad-30 ova-btn-white" href="'.$button_link.'">'.$button_text.'</a></div>' : '';

                                           $html .= ( $show_countdown == 'yes' ) ? '<div class="ova_countdown_slideshow"><div class="ova_countdown_event" data-day="'.$day.'" data-month="'.$month.'" data-year="'.$year.'" data-timezone_string="'.$timezone_string.'" data-hour="'.$hour.'" data-minute="'.$minute.'" data-timezone="'.$timezone.'"></div></div>' : '';
                                    
        $html .= '</div></div></div></div></div>';

    
    return $html;
}



add_shortcode('ova_adevent_main_slider_two', 'ova_adevent_main_slider_two');
function ova_adevent_main_slider_two($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'auto_slider' => 'true',
      'duration'    => '3000',
      'navigation'  => 'true',
      'loop'        => 'true',
      'height_desk' => '680px',
      'height_ipad' => '768px',
      'height_mobile' => '800px',
      'padding_top_desk'  => '230px',
      'padding_top_ipad'  => '230px',
      'padding_top_mobile'  => '230px',
      'class'       => '',
    ), $atts) );
    

    $html = '';
    $html .= '<div class="main_slider main_slider_v1 main_slider_v2 owl-carousel '.$class.'" data-height_desk="'.$height_desk.'"  data-height_ipad="'.$height_ipad.'" data-height_mobile="'.$height_mobile.'" data-loop="'.$loop.'" data-auto_slider="'.$auto_slider.'" data-duration="'.$duration.'" data-navigation="'.$navigation.'" data-padding_top_desk="'.$padding_top_desk.'" data-padding_top_ipad="'.$padding_top_ipad.'" data-padding_top_mobile="'.$padding_top_mobile.'" >';
    
    $html .= do_shortcode($content);

    $html .= '</div>';

    
    return $html;
}



add_shortcode('ova_adevent_main_slider_two_item', 'ova_adevent_main_slider_two_item');
function ova_adevent_main_slider_two_item($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'img'  => '',
      'hour'  => '',
      'date'    => '',
      'address'       => '',
      'title'       => '=',
      'sub_title' => '=',
      'button_text'    => '=',
      'button_link'  => '=',
      'cover_bg'     => 'true',
      'class'       => '',
    ), $atts) );

    $img = wp_get_attachment_url( $img, 'full' ) ? wp_get_attachment_url( $img, 'full' ) : '';
    
    
    

    $html = '<div class="item text-center '.$class.'" style="background-image: url('.$img.')" data-speed="10">';

                    $html .= ($cover_bg == 'true') ? '<div class="cover_bg"></div>':'';

                    $html.= '<div class="caption">
                                <div class="container">
                                    <div class="div-table">
                                        <div class="div-cell">';

                                           $html .= '<div class="slider_date">';
                                           
                                             $html .= $date ? '<div class="box"><i class="icon_clock_alt"></i> <span>'.$hour.'</span></div>' : '';

                                            $html .= $date ? '<div class="box"><i class="icon_calendar"></i> <span>'.$date.'</span></div>' : '';

                                            $html .= $address ? '<div class="box"><i class="icon_pin_alt"></i> <span>'.$address.'</span></div>' : '';

                                           $html .= '</div>';

                                           $html .= $title ? '<h2 class="title">'.$title.'</h2>' : '';

                                           $html .= $sub_title ? '<h3 class="sub_title">'.$sub_title.'</h3>' : '';

                                           $html .= $button_text ? '<div class="ova_button"><a class="ova-btn ova-btn-white" href="'.$button_link.'">'.$button_text.'</a></div>' : '';

                                          
                                    
        $html .= '</div></div></div></div></div>';

    
    return $html;
}



add_shortcode('ova_adevent_banner_one', 'ova_adevent_banner_one');
function ova_adevent_banner_one($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'icon' => '',
      'img' => '',
      'date' => '',
      'title' => '',
      'desc' => '',
      'class'       => '',
    ), $atts) );
    
    $img = wp_get_attachment_url( $img, 'full' ) ? wp_get_attachment_url( $img, 'full' ) : '';

    $html = '<div class="banner_one '.$class.'">';

      $html .= '<div class="event_icon">';
        $html .= $icon ? '<i class="'.$icon.'"></i>' : '';
        $html .= $img ? '<img src="'.$img.'" alt="'.$title.'" />' : '';
      $html .= '</div>';


      $html .= $date ? '<div class="date"><span>'.$date.'</span></div>' : '';

      $html .= $title ? '<h1 class="title">'.$title.'</h1>' : '';

      $html .= $desc ? '<h2 class="desc">'.$desc.'</h2>' : '';

    $html .= '</div>';
    
    return $html;
}




add_shortcode('ova_adevent_service', 'ova_adevent_service');
function ova_adevent_service($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'icon'  => '',
      'title' => '',
      'desc'  => '',
      'read_more_text'  => '',
      'read_more_icon'  => 'arrow_right',
      'read_more_link'  => '',
      'target'  => '_self',
      'style' => 'style1',
      'class' => '',
    ), $atts) );
    
    $html = '<div class="ova_service ova-trans '.$style.' '.$class.'">';
      $html .= $icon ? '<div class="icon"><i class="'.$icon.'"></i></div>' : '';
      $html .= $title ? '<h3 class="title">'.$title.'</h3>' : '';
      $html .= $desc ? '<div class="desc">'.$desc.'</div>' : '';
      if( $read_more_icon != '' ){
        $html .= $read_more_icon ? '<div class="read_more"><a target="'.$target.'" href="'.$read_more_link.'"><i class="'.$read_more_icon.'"></i></a></div>' : '';
      }else{
        $html .= $read_more_text ? '<div class="read_more"><a target="'.$target.'" href="'.$read_more_link.'">'.$read_more_text.'</a></div>' : '';
      }
      
    $html .= '</div>';
    
    return $html;
}



add_shortcode('ova_adevent_heading', 'ova_adevent_heading');
function ova_adevent_heading($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'title' => '',
      'sub_title'  => '',
      'class' => '',
    ), $atts) );

    $html = '<div class="ova_heading '.$class.'">';
      $html .= $title ? '<h3 class="title">'.$title.'</h3>' : '';
      $html .= $sub_title ? '<div class="sub_title">'.$sub_title.'</div>' : '';
    $html .= '</div>';
    
    return $html;
}

add_shortcode('ova_adevent_heading_v2', 'ova_adevent_heading_v2');
function ova_adevent_heading_v2($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'title' => '',
      'sub_title'  => '',
      'img' => '',
      'class' => '',
    ), $atts) );

    $img = wp_get_attachment_url( $img, 'full' ) ? wp_get_attachment_url( $img, 'full' ) : '';

    $html = '<div class="ova_heading_v2 '.$class.'">';
      $html .= '<div class="wrap_title">';
        $html .= $title ? '<h3 class="title">'.$title.'</h3>' : '';
        $html .= $img ? '<img src="'.$img.'" alt="'.$title.'" />' : '';
      $html .= '</div>';

      $html .= $sub_title ? '<div class="sub_title">'.$sub_title.'</div>' : '';
    $html .= '</div>';
    
    return $html;
}

add_shortcode('ova_adevent_heading_v3', 'ova_adevent_heading_v3');
function ova_adevent_heading_v3($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'title' => '',
      'sub_title'  => '',
      'class' => '',
    ), $atts) );

    $html = '<div class="ova_heading_v3 '.$class.'"><span class="one"></span><span class="two"></span><span class="three"></span><span class="four"></span><span class="five"></span><span class="six"></span>';
    $html .= $sub_title ? '<div class="sub_title">'.$sub_title.'</div>' : '';
      $html .= $title ? '<h3 class="title">'.$title.'</h3>' : '';
    $html .= '</div>';
    
    return $html;
}

add_shortcode('ova_adevent_heading_v4', 'ova_adevent_heading_v4');
function ova_adevent_heading_v4($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'title' => '',
      'sub_title'  => '',
      'show_line' => 'true',
      'class' => '',
    ), $atts) );

    $html = '<div class="ova_heading_v4 '.$class.'">';
      $html .= $title ? '<h3 class="title">'.str_replace('}', '</span>', str_replace('{', '<span>', $title) ) .'</h3>' : '';
      $html .= ( $sub_title != '' || $show_line == 'true' ) ? '<div class="sub_title">'.$sub_title.'</div>' : '';
    $html .= '</div>';
    
    return $html;
}

add_shortcode('ova_adevent_box', 'ova_adevent_box');
function ova_adevent_box($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'number'  => '',
      'title' => '',
      'desc'  => '',
      'btn_link' => '',
      'style' => 'styl1',
      'class' => '',
    ), $atts) );

    $html = '<div class="ova_box ova-trans '.' '.$style.' '.$class.'">';
      $html .= $number ? '<div class="num">'.$number.'</div>' : '';
      $html .= '<div class="wrap_content">';
        if( $btn_link ){
          $html .= $title ? '<h3 class="title"><a href="'.$btn_link.'" class="ova-trans">'.$title.'</a></h3>' : '';
        }else{
          $html .= $title ? '<h3 class="title">'.$title.'</h3>' : '';
        }
        
        $html .= $desc ? '<div class="desc">'.$desc.'</div>' : '';
      $html .= '</div>';
    $html .= '</div>';
    
    return $html;
}





add_shortcode('ova_adevent_blog', 'ova_adevent_blog');
function ova_adevent_blog($atts, $content = null) {

$atts = extract( shortcode_atts(
array(
  'category'  =>  '',
  'total_count' => '20',
  'show_thumb'  =>  'true',
  'show_readmore' =>  'true',
  'show_title'  =>  'true',
  'show_desc' =>  'true',
  'show_comment'  =>  'true',
  'show_date' =>  'true',
  'auto_slider' => 'true',
  'duration'    => '3000',
  'dots'  => 'true',
  'loop'        => 'true',
  'class' => '',
), $atts) );

$args =array();
  if ($category=='all') {
    $args=array('post_type' => 'post', 'posts_per_page' => $total_count);
  }else{
    $args=array('post_type' => 'post', 'category_name'=>$category,'posts_per_page' => $total_count);
  }
$html = '';
$blog = new WP_Query($args);



$html .= '<div  class="owl-carousel ova_blog '.$class.'" data-loop="'.$loop.'" data-auto_slider="'.$auto_slider.'" data-duration="'.$duration.'" data-dots="'.$dots.'">';

    if($blog->have_posts()) : while($blog->have_posts()) : $blog->the_post();
   
     $html .= '<div class="content ova-trans">';

            if($show_thumb == 'true'){

              $html .= '<div class="ova_media">';

                
                $thumbnail_url_d = wp_get_attachment_image_url(get_post_thumbnail_id() , 'd_img' );
                $thumbnail_url_m = wp_get_attachment_image_url(get_post_thumbnail_id() , 'm_img' );

                $html .= $thumbnail_url_d ? '<a href="'.get_the_permalink().'" class="img_media"><img  src="'.$thumbnail_url_d.'" alt="'.get_the_title().'" class="img-responsive" srcset=" '.$thumbnail_url_d.' 1200w ,'.$thumbnail_url_m.' 767w" sizes="(max-width: 600px) 100vw, 600px"  ></a>' : '';

                $icon_img = has_post_format('video') ? 'icon_film' : 'icon_image';

                $html .= $show_readmore == 'true' ? '<a class="blog_link" href="'.get_the_permalink().'"><i class="ova_icon '.$icon_img.'"></i><i class="arrow_right"></i></a>' : '' ;
              
              $html .= '</div>';

            }

            $the_excerpt = get_the_content() ? get_the_excerpt() : '';
                  
            $html .= $show_title == 'true' ? '<h2 class="title"><a href="'.get_the_permalink().'">'.get_the_title( ).'</a></h2>' : '';
            $html .= $show_desc == 'true' ? '<div class="desc">'.$the_excerpt.'</div>' : '';

            $html .= '<div class="post-meta">';
                $html .= $show_date == 'true' ? '<div class="post-date"><i class="icon_calendar"></i>&nbsp;<span class="day"> '.get_the_time( get_option( 'date_format' )).'</span></div>' : '';
                
                $comment_text = ( get_comments_number() == 1 ) ? esc_html__( 'comment', 'adventpro' ) : esc_html__( 'comments', 'adventpro' );

                $html .= $show_comment == 'true' ? '<div class="post-comment"><i class="icon_comment_alt "></i>&nbsp;'.get_comments_number().' '.$comment_text.'</div>' : '';
                
            $html .= '</div>';


              

    $html .= '</div>';
    
  endwhile; endif;wp_reset_postdata();

$html .= '</div>';

return $html;

}


add_shortcode('ova_advent_map1', 'ova_advent_map1');
function ova_advent_map1($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'img'  => '',
      'style' => 'style1',
      'class' => '',
    ), $atts) );

    $img = wp_get_attachment_url( $img, 'full' ) ? wp_get_attachment_url( $img, 'full' ) : '';

    $html = '<div class="'.$class.' '.$style.'">';
      
      if( $style == 'style2' ){ $html .= '<div class="container"><div class="row">'; }

        $html .= '<div class="ova_map1">';
          $html .= '<div class="content">';
            $html .= '<img src="'.$img.'" alt="'.esc_html__('logo', 'adventpro').'" />';
            $html .= do_shortcode( $content );
          $html .= '</div>';
        $html .= '</div>';

      if( $style == 'style2' ){ $html .= '</div></div>'; }

    $html .= '</div>';
    
    return $html;
}



add_shortcode('ova_advent_info', 'ova_advent_info');
function ova_advent_info($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'icon'  => '',
      'title' => ''
    ), $atts) );

    $html = '<div class="info"><i class="'.$icon.'"></i>'.$title.'</div>';
    
    return $html;
}

add_shortcode('ova_advent_social', 'ova_advent_social');
function ova_advent_social($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'class' => ''
    ), $atts) );

    $html = '<ul class="social_theme '.$class.'">'.do_shortcode($content).'</ul>';
    
    return $html;
}

add_shortcode('ova_advent_social_item', 'ova_advent_social_item');
function ova_advent_social_item($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'icon'  => '',
      'link' => '',
      'class' => ''
    ), $atts) );

    $html = '<li class="'.$class.' "><a href="'.$link.'" target="_blank"><i class="'.$icon.'"></i></a></li>';
    
    return $html;
}



add_shortcode('ova_advent_gallery', 'ova_advent_gallery');
function ova_advent_gallery($atts, $content = null) {

  

    $atts = extract( shortcode_atts(
    array(
      'class' => ''
    ), $atts) );

    $html = '<ul class="gallery '.$class.'">'.do_shortcode($content).'</ul>';
    
    return $html;
}


add_shortcode('ova_advent_gallery_item', 'ova_advent_gallery_item');
function ova_advent_gallery_item($atts, $content = null) {

  wp_enqueue_script('prettyphoto', EM4U_URI.'/assets/plugins/prettyphoto/jquery.prettyPhoto.js', array('jquery'),null,true);
  wp_enqueue_style('prettyphoto', EM4U_URI.'/assets/plugins/prettyphoto/prettyPhoto.css', array(), null);

    $atts = extract( shortcode_atts(
    array(
      'thumbnail'  => '',
      'popup_img' => '',
      'title' => '',
    ), $atts) );

    $html = '<li><a href="'.$popup_img.'" data-gal="prettyPhoto[gal]" title="'.$title.'"><img src="'.$thumbnail.'" alt="'.$title.'" /></a></li>';
    
    return $html;
}


add_shortcode('ova_advent_skill', 'ova_advent_skill');
function ova_advent_skill($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'icon'  => '',
      'name' => '',
      'number' => '',
      'class' => '',
    ), $atts) );

    $html = '<div class="ovaem_skill '.$class.'">';
      
      $html .= '<div class="top">';
        $html .= '<i class="'.$icon.'"></i>';
        $html .= '<div class="number">'.$number.'</div>';
      $html .= '</div>';

      $html .= '<div class="name">'.$name.'</div>';

    $html .= '</div>';
    
    return $html;
}

add_shortcode('ova_advent_button', 'ova_advent_button');
function ova_advent_button($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'name'  => '',
      'link'  => '',
      'target' => '_self',
      'size' => 'ova-btn-large',
      'radius' => 'ova-btn-rad-4',
      'bg_main_color' => 'ova-btn-transparent',
      'class' => '',
    ), $atts) );

    $html = '<div class="'.$class.'">';
      
      $html .= '<a href="'.$link.'" target="'.$target.'" class="ova-btn '.$size.' '.$radius.' '.$bg_main_color.' ">'.$name.'</a>';

    $html .= '</div>';
    
    return $html;
}

add_shortcode('ova_advent_join_event', 'ova_advent_join_event');
function ova_advent_join_event($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'title'  => '',
      'desc'  => '',
      'class' => '',
    ), $atts) );

    $html = '<div class="join_event '.$class.'">';
      
      $html .= '<div class="title">'.$title.'<span class="one"></span><span class="two"></span><span class="three"></span></div>';
      $html .= '<div class="sub_title">'.$desc.'</div>';

    $html .= '</div>';
    
    return $html;
}

add_shortcode('ova_advent_info_event', 'ova_advent_info_event');
function ova_advent_info_event($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'icon'  => '',
      'title'  => '',
      'desc'  => '',
      'class' => '',
    ), $atts) );

    $html = '<div class="event_info '.$class.'">';
      
      $html .= '<div class="icon"><i class="'.$icon.'"></i></div>';

      $html .= '<div class="info">';

        $html .= '<div class="title">'.$title.'</div>';

        $html .= '<div class="desc">'.$desc.'</div>';

      $html .= '</div>';
      
    $html .= '</div>';
    
    return $html;
}


add_shortcode('ova_advent_about', 'ova_advent_about');
function ova_advent_about($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'icon_img'  => '',
      'title'  => '',
      'desc'  => '',
      'btn_link' => '',
      'btn_text' => '',
      'class' => '',
    ), $atts) );

    $icon_img = wp_get_attachment_url( $icon_img, 'full' ) ? wp_get_attachment_url( $icon_img, 'full' ) : '';

    $html = '<div class="about_info '.$class.'">';

        $html .= '<div class="title">';

          $html .= '<img src="'.$icon_img.'" alt="'.$title.'" />';
          $html .= '<h3>'.$title.'</h3>';

        $html .= '</div>';

        $html .= '<div class="desc">'.$desc.'</div>';

        $html .= '<div class="btn_video  "><a class="scroll ova-btn ova-btn-large ova-btn-main-color" href="'.$btn_link.'">'.$btn_text.'</a></div>';

     
      
    $html .= '</div>';
    
    return $html;
}


add_shortcode('ova_advent_testimonial', 'ova_advent_testimonial');
function ova_advent_testimonial($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'count'  => '2',
      'auto_slider' => 'true',
      'duration'    => '3000',
      'pagination'  => 'true',
      'loop'        => 'true',
      'class' => '',
    ), $atts) );

    

    $html = '<div class="event_testimonial '.$class.'" data-loop="'.$loop.'" data-auto_slider="'.$auto_slider.'" data-duration="'.$duration.'" data-pagination="'.$pagination.'" data-count="'.$count.'">';

       $html .= do_shortcode( $content );
      
    $html .= '</div>';
    
    return $html;
}

add_shortcode('ova_advent_testimonial_item', 'ova_advent_testimonial_item');
function ova_advent_testimonial_item($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'image'  => '',
      'name'  => '',
      'job'  => '',
      'desc'  => '',
      'show_quota'  => '',
      'class' => '',
    ), $atts) );

    $image = wp_get_attachment_url( $image, 'full' ) ? wp_get_attachment_url( $image, 'full' ) : '';
    

    $html = '<div class="item '.$class.'">';

       $html .= '<div class="desc">'.$desc.'</div>';
       $html .= '<div class="author">';
        $html .= '<img src="'.$image.'" alt="'.$name.'">';
        $html .= '<div class="info">';
          $html .= '<div class="name">'.$name.'</div>';
          $html .= '<div class="job">'.$job.'</div>';
        $html .= '</div>'; 
       $html .= '</div>';
      
    $html .= '</div>';
    
    return $html;
}


add_shortcode('ova_advent_gallery_v1', 'ova_advent_gallery_v1');
function ova_advent_gallery_v1($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'count'  => '2',
      'auto_slider' => 'true',
      'duration'    => '3000',
      'pagination'  => 'true',
      'navigation'  => 'true',
      'loop'        => 'true',
      'class' => '',
    ), $atts) );

    

    $html = '<div class="event_gallery_v1 '.$class.'" data-loop="'.$loop.'" data-auto_slider="'.$auto_slider.'" data-duration="'.$duration.'" data-navigation='.$navigation.' data-pagination="'.$pagination.'" data-count="'.$count.'">';

       $html .= do_shortcode( $content );
      
    $html .= '</div>';
    
    return $html;
}

add_shortcode('ova_advent_gallery_v1_item', 'ova_advent_gallery_v1_item');
function ova_advent_gallery_v1_item($atts, $content = null) {

  wp_enqueue_script('prettyphoto', EM4U_URI.'/assets/plugins/prettyphoto/jquery.prettyPhoto.js', array('jquery'),null,true);
  wp_enqueue_style('prettyphoto', EM4U_URI.'/assets/plugins/prettyphoto/prettyPhoto.css', array(), null);

    $atts = extract( shortcode_atts(
    array(
      'image'  => '',
      'thumbnail' => '',
      'title'  => '',
      'date'  => '',
      'class' => '',
    ), $atts) );

    $image = wp_get_attachment_url( $image, 'full' ) ? wp_get_attachment_url( $image, 'full' ) : '';
    $thumbnail = wp_get_attachment_url( $thumbnail, 'full' ) ? wp_get_attachment_url( $thumbnail, 'full' ) : '';
    

    $html = '<div class="item '.$class.'">';

     $html .= '<div class="img">';
      $html .= '<img src="'.$thumbnail.'" alt="'.$title.'" />';
      $html .= '<div class="preview"><a href="'.$image.'"  data-gal="gallery_v1[gal]" ><span class="ova-btn ova-btn-medium ova-btn-main-color ova-btn-rad-30">'.esc_html__( 'Preview', 'adventpro' ).'</span></a></div>';
     $html .= '</div>';

     $html .= '<div class="info">';
      $html .= '<div class="title">'.$title.'</div>';
      $html .= '<div class="date">'.$date.'</div>';
     $html .= '</div>';  

    $html .= '</div>';
    
    return $html;
}



add_shortcode('ova_advent_contact_info', 'ova_advent_contact_info');
function ova_advent_contact_info($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'icon'  => '',
      'title' => '',
      'desc'    => '',
      'class' => '',
    ), $atts) );

    

    $html = '<div class="contact_info '.$class.'">';

      $html .= $icon ? '<div class="icon"><i class="'.$icon.'"></i></div>' : '';
      $html .= $title ? '<div class="title">'.$title.'</div>' : '';
      if( $desc ){
        $desc = str_replace( '}}', '</span>', str_replace( '{{', '<span>', $desc ) );
        $html .= $desc ? '<div class="desc">'.$desc.'</div>' : '';  
      }
      

    $html .= '</div>';
    
    return $html;
}

add_shortcode('ova_advent_header_v3', 'ova_advent_header_v3');
function ova_advent_header_v3($atts, $content = null) {

    $atts = extract( shortcode_atts(
    array(
      'icon'  => '',
      'title' => '',
      'class' => '',
    ), $atts) );

    

    $html = '<div class="item_top '.$class.'">
              <i class="'.$icon.'"></i>
              <span>'.$title.'</span>
            </div>';
    
    return $html;
}


/* Map */
add_shortcode('ova_advent_map', 'ova_advent_map');
function ova_advent_map($atts, $content = null) {

if( class_exists( 'OVAEM' ) ){
  if( OVAEM_Settings::google_key_map() != '' ){
    wp_enqueue_script( 'google-map-api','//maps.googleapis.com/maps/api/js?key='.OVAEM_Settings::google_key_map().'&libraries=places', array('jquery'),null,true );
    echo '<script>var google_map = true;</script>';
  }else{
    echo '<script>var google_map = false;</script>';
  }  
}



$atts = shortcode_atts(
    array(
      'idmap'  => 'gmap-canvas',
      'location'  => '',
      'title'   => '',
      'zoom'      => '15',
      'icon'  => '',
      'class'  => '',
    ), $atts);
   
   

$icon = wp_get_attachment_image_src($atts['icon'], 'medium');

if( is_array($icon) ) {

  $icon0 = $icon[0];

}else{
  $icon0 = "";
}


    $html = '<div class="event-google-map-wrap '.$atts['class'].'">
                <div class="event-google-map" data-zoom="'.$atts['zoom'].'" 
                    data-icon="'.$icon0.'" 
                    data-title="'.htmlentities(rawurldecode( base64_decode( strip_tags( $atts['title'] ) ) )).'" 
                    data-location="'.htmlentities(rawurldecode( base64_decode( strip_tags( $atts['location'] ) ) ) ).'" 
                    data-idmap="'.$atts['idmap'].'">
                  <div id="'.trim($atts['idmap']).'" class="iframemap"></div>
              </div>
            </div>';

    return $html;

}


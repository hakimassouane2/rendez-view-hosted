<!DOCTYPE html>
<html <?php language_attributes(); ?> >

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
    <link rel="profile" href="//gmpg.org/xfn/11">
    <link href='//fonts.gstatic.com' rel='preconnect' crossorigin>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >
<?php wp_body_open(); ?>
    

    <?php $header = em4u_get_current_header();  ?>
    <?php $bg_page = get_post_meta( get_the_id(), 'em4u_met_bg_page', true ) ? get_post_meta( get_the_id(), 'em4u_met_bg_page', true ) : 'bg_white'; ?>

    <div class="ovatheme_container_<?php echo esc_attr(em4u_get_current_width_site()); ?> event_header_<?php   echo esc_attr($header); ?> <?php echo esc_attr($bg_page); ?>">
    	
        <?php get_template_part( 'header/header', $header ); ?>
        
      
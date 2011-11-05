<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
    
    <title><?php
    if ( is_single() ) { single_post_title(); }
    elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }
    elseif ( is_page() ) { single_post_title(''); }
    elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); get_page_number(); }
    elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
    else { bloginfo('name'); wp_title('|'); get_page_number(); }
?></title>
 
    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
 
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
 	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri();?>/demo.css " />
     	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri();?>/reset.css " />
 
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_enqueue_script('jquery'); ?>
 
    <?php wp_head(); ?>
 	
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'your-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'your-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<noscript>
			<style>
				.st-accordion ul li{
					height:auto;
				}
				.st-accordion ul li > a span{
					visibility:hidden;
				}
			</style>
		</noscript>


</head>
<body <?php body_class(); ?>>
<div id="container" class="hfeed container"><!--wrapper-->
    <div id="header"><!--start header-->
        <div id="masthead">
 
            <div id="branding">
                <div id="page-<?php the_ID() ?>"<span><a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></span></div>
<?php if ( is_home() || is_front_page() ) { ?>
                    <h1 id="blog-description"><?php bloginfo( 'description' ) ?></h1>
<?php } else { ?>
                    <div id="blog-description"><?php bloginfo( 'description' ) ?></div>
<?php } ?>
            </div><!-- #branding -->
 
            <div id="access">
    <div class="skip-link"><a href="#content" title="<?php _e( 'Skip to content', 'your-theme' ) ?>"><?php _e( 'Skip to content', 'your-theme' ) ?></a></div>
    <?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'menu-header' ) ); ?>
</div><!-- #access -->
 
        </div><!-- #masthead -->
    </div><!-- #header -->
 
    <div id="main" class="wrapper"><!--start main-->
<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Amaranth
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Global site tag (gtag.js) - Google Analytics
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-62570293-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-62570293-1');
    </script> -->
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- <meta property="fb:app_id" content="632855303452563"> -->
    <meta property="og:title" content="<?php bloginfo('title'); ?>">
    <meta property="og:description" content="<?php bloginfo('description'); ?>">
    <meta property="og:image" content="<?php echo wp_get_attachment_image_src(7, 'full')[0]; ?>">
    <meta property="og:type" content="website">

    <link rel="profile" href="https://gmpg.org/xfn/11">
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php echo GateKeeper::get_template_part('parts/background-animation'); ?>
<div id="app" class="site">
    <div class="site-wrapper">
    <a class="skip-link sr-only" href="#content"><?php esc_html_e( 'Skip to content', 'amaranth' ); ?></a>
    <header id="masthead" class="site-header">
        <div class="site-branding">
            <?php
            the_custom_logo();
            if ( is_front_page() && is_home() ) :
                ?>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php
            else :
                ?>
                <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php
            endif;
            $amaranth_description = get_bloginfo( 'description', 'display' );
            if ( $amaranth_description || is_customize_preview() ) :
                ?>
                <p class="site-description"><?php echo $amaranth_description; /* WPCS: xss ok. */ ?></p>
            <?php endif; ?>
        </div><!-- .site-branding -->
    </header><!-- #masthead -->

    <div id="content" class="site-content">

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!doctype html>
<html>
<head>

	<!--META TAGS-->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="Language" content="English">
    <meta name="Revisit" content="1 day">
    <!--META TAGS-->
    
    <!--RESPONSIVE-->
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!--RESPONSIVE-->
    
	<title><?php wp_title('––'); ?></title>
	
	<!--CANONICAL-->
	<link rel="canonical" href="<?php the_permalink(); ?>">
	<!--CANONICAL-->
    
    <!--RSS-->
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="Atom" href="<?php bloginfo('atom_url'); ?>" />
    <!--RSS-->

    <!--CSS-->
    <link type="text/css" rel="stylesheet" href="<?=getPath('app','css')?>" />
    <!--CSS-->

	<!--ICONS-->
	<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/images/favicon.png" />
	<link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_url'); ?>/images/apple.png"/>
	<!--ICONS-->
    
    <?php wp_head(); ?> 
    
</head>

<body <?php body_class();?>>
	<div id="wrapper">
		<div id="header">
    		<div class="content">
                <div id="title-top"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></div>
				<?php wp_nav_menu( array( 'container' => 'div', 'container_id' => 'main-menu', 'container_class' => 'menu', 'menu_class' => 'menu-list', 'menu_id' => 'main-menu-list', 'menu' => 'main-menu') ); ?>
			</div><!--CONTENT-->
        </div><!--HEADER-->
        <div id="body">
    		<div class="content">
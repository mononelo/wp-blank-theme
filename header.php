<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!doctype html>
<html>
<head>

	<!--META TGS-->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="Title" content="<?php bloginfo('name'); ?>">
    <meta name="Author" content="">
    <meta name="Description" content="<?php bloginfo('description'); ?>">
    <meta name="Keywords" content="">
    <meta name="Language" content="English">
    <meta name="Revisit" content="1 day">
    <meta name="Distribution" content="Global">
    <meta name="Robots" content="All">
    <!--META TGS-->
    
	<title><?php wp_title('––'); ?></title>
    
    <!--RSS-->
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="Atom" href="<?php bloginfo('atom_url'); ?>" />
    <!--RSS-->

    <!--CSS-->
    <link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/fonts.css" />
    <link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/inc/fancybox/jquery.fancybox.min.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
    <!--CSS-->

	<!--ICONS-->
	<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/images/favicon.png" />
	<link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_url'); ?>/images/apple.png"/>
    
    <!--RESPONSIVE-->
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!--RESPONSIVE-->
    
    <?php wp_head(); ?> 
    
</head>

<body <?php body_class();?> onResize="javascript:resize();">
	<div id="wrapper">
		<div id="header">
    		<div class="content">
                <h1 id="title-top"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
                <h2 id="desc-top"><?php bloginfo('description'); ?></h2>
                <?php wp_nav_menu( array( 'container' => 'top-menu', 'menu' => 'top-menu') ); ?>
			</div><!--CONTENT-->
        </div><!--HEADER-->
        <div id="body">
    		<div class="content">
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="robots" content="noindex,nofollow">
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/jquery.onscreen.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js"></script-->
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css?ver=<?php echo date('U'); ?>">
<title><? echo wp_get_document_title(); ?></title>
</head>
<body onload="splash(2000)">
    <div class="splash">
		<div class="splash__content">
		  <div class="splash__cover">
				<p class="splash__title">Portfolio<span class="splash__title--year"><?php echo date('Y'); ?></span></p>
				<p class="splash__subtitle">singapore&nbsp;&nbsp;vietnam&nbsp;&nbsp;thailand</p>
		  </div>
		</div>
		<div class="splash__footer">
			<p class="splash__author">SUSUMU SAKAI / 酒井奨</p>
		</div>
	</div> 
	<header class="header">
    	<div class="header__arrow">
      		SCROLL DOWN 
		</div>
    </header>
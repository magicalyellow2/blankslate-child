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
<!--script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script-->
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js"></script>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css?ver=<?php echo date('U'); ?>">
<title><? echo wp_get_document_title(); ?></title>
</head>
<body>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="header">
			<div class="header__arrow"></div>
			<h1 class="entry__title" itemprop="name"><?php the_title(); ?></h1>
		</div>
		<div class="entry__content" itemprop="mainContentOfPage">
			<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ); } ?>
			<?php the_content(); ?>
			<div class="entry__links"><?php wp_link_pages(); ?></div>
		</div>
	</article>
	<?php if ( comments_open() && !post_password_required() ) { comments_template( '', true ); } ?>
	<?php endwhile; endif; ?>
<p class="page-top"><a class="page-top__link" href="#">TOP</a></p>
    <footer class="footer">
		<div class="footer__site-name">
			<a class="footer__site-name-link" href="<?php echo home_url(); ?>">Portfolio.</a>
		</div>
        <div class="footer__menu">
				<?php echo get_footer_menu(); ?>
			</div>
    </footer>
	<script>
	<?php echo jq_on_screen('.entry-content'); ?>
	<?php echo jq_page_top(); ?>
	<?php echo jq_hamburger_menu(); ?>
	</script>
</body>
</html>
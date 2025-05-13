<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
<div class="header">
  <h1 class="entry__title" itemprop="name"><?php printf( esc_html__( 'Search Results for: %s', 'blankslate' ), get_search_query() ); ?></h1>
</div>
<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'entry' ); ?>
<?php endwhile; ?>
<?php get_template_part( 'nav', 'below' ); ?>
<?php else : ?>
<article id="post-0" class="post no-results not-found">
  <div class="header">
    <h1 class="entry__title" itemprop="name"><?php esc_html_e( 'Nothing Found', 'blankslate' ); ?></h1>
  </div>
  <div class="entry__content" itemprop="mainContentOfPage">
    <p class="no-content"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'blankslate' ); ?></p>
  </div>
</article>
<?php endif; ?>
<?php get_footer(); ?>
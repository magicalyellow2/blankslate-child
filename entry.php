<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry__wrapper">
<div class="entry__container">
<?php if ( is_singular() ) { echo '<h1 class="entry__title" itemprop="headline">'; } else { echo '<h2 class="entry__title">'; } ?>
<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
<?php if ( is_singular() ) { echo '</h1>'; } else { echo '</h2>'; } ?>
<?php get_template_part( 'entry', ( is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
<?php if ( is_singular() ) { get_template_part( 'entry-footer' ); } ?>
</div>
</div>
</article>
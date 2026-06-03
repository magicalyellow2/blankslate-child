<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry__wrapper">
    <div class="entry__container">
        <?php if ( is_singular() ) { echo '<h1 class="entry__title entry__title--kv" itemprop="headline">'; } else { echo '<h2 class="entry__title">'; } ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
        <?php if ( is_singular() ) { echo '</h1>'; } else { echo '</h2>'; } ?>
        <?php get_template_part( 'entry', ( is_front_page() || is_home() || is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
        <?php if ( is_singular() ) { get_template_part( 'entry-footer' ); } ?>

        <?php
        /* 前後作品ナビ */
        if ( is_singular() ) :
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            if ( $prev_post || $next_post ) : ?>
            <nav class="entry__pager" aria-label="前後の作品">
                <?php if ( $prev_post ) : ?>
                <a class="entry__pager-prev" href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>">
                    <?php echo esc_html( get_the_title( $prev_post ) ); ?>
                </a>
                <?php else : ?>
                <span class="entry__pager-prev" style="opacity:.2; pointer-events:none;">最初の作品</span>
                <?php endif; ?>

                <?php if ( $next_post ) : ?>
                <a class="entry__pager-next" href="<?php echo esc_url( get_permalink( $next_post ) ); ?>">
                    <?php echo esc_html( get_the_title( $next_post ) ); ?>
                </a>
                <?php else : ?>
                <span class="entry__pager-next" style="opacity:.2; pointer-events:none;">最後の作品</span>
                <?php endif; ?>
            </nav>
            <?php endif;
        endif; ?>

    </div>
</div>
</article>
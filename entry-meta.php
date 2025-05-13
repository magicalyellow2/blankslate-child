<div class="entry__meta">
  <span class="entry__meta-item author vcard"<?php if ( is_single() ) { echo ' itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name">'; } else { echo '><span>'; } ?><?php the_author(); ?></span>
  <span class="entry__meta-separator"> | </span>
  <time class="entry__meta-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" title="<?php echo esc_attr( get_the_date() ); ?>" <?php if ( is_single() ) { echo 'itemprop="datePublished" pubdate'; } ?>><?php echo esc_html( get_the_date() ); ?></time>
  <?php if ( is_single() ) { echo '<meta itemprop="dateModified" content="' . esc_attr( get_the_modified_date() ) . '" />'; } ?>
</div>
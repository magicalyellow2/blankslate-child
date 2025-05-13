<?php
$args = array(
  'prev_text' => '<span class="nav__meta">&larr;</span> %title',
  'next_text' => '%title <span class="nav__meta">&rarr;</span>'
);
the_post_navigation( $args );
?>
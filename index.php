<?php get_header() . "\n"; ?>
    <main> 
	<div class="container">
		<?php
			$post_array = array();
			if(have_posts()) : 
			while(have_posts()): the_post();
			$permalink = get_the_permalink();
			$thumb_path = wp_get_attachment_url( get_post_thumbnail_id() );
			$thumb_attr =  get_ratiocal($thumb_path,(get_thumbnail_width() - 20));
			$post_title = get_the_title();
			$post_array[] = '<div class="card">' . 
				'<span class="card__label">' . esc_html($post_title) . '</span>' . 
				'<a href="' . esc_url($permalink) . '" title="' . esc_attr($post_title) . '" class="card__link">' . 
				'<img class="card__image" src="' . esc_url($thumb_path) . '"' . $thumb_attr . ' alt="' . esc_attr($post_title) . '">' . 
				'</a>' . 
				'</div>';
			endwhile;
			shuffle($post_array);
			$post_image = implode("\n", $post_array) . "\n";
			endif;

			if(!empty($post_image)){
				echo $post_image;
			}else{
				echo '<p class="contents_not_found">' . esc_html__('No content found.', 'blankslate-child') . '</p>';
			}
		?>
	</div>
    </main>
<?php get_footer() . "\n"; ?>
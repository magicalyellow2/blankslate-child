<div class="entry-content" itemprop="mainEntityOfPage">
<?php if ( has_post_thumbnail() ) : ?>
<?php
$post_id = get_the_ID();
if(get_field('acf-clinet',$post_id)) {	
	//課題と戦略の引き出し
	$assignment = (get_field('acf-assignment',$post_id)) ? '<div class="task-assignment">' . get_field('acf-assignment') . 
								'</div><span class="dli-caret-down"></span>' : '';
	$strategy = (get_field('acf-strategy',$post_id)) ? '<div class="task-strategy">' . get_field('acf-strategy') . '</div>' : '';
	
	//業務情報の引き出し
	$client = (get_field('acf-clinet',$post_id)) ? '<div>' . 'CL: ' . get_field('acf-clinet',$post_id) . ' / ' . get_field('acf-type',$post_id) . '</div>' : '' ;
	$year = (get_field('acf-year',$post_id)) ? '<div>' . get_field('acf-year',$post_id) . ' / ' . get_field('acf-place',$post_id) . '</div>' : '';
	$incharge = (get_field('acf-in-charge',$post_id)) ? '<div class="task-incharge">担当：' . get_field('acf-in-charge',$post_id) . '</div>' : '';
	$task_info = (!empty($incharge)) ? '<div class="task-info">' . $client . $year . '</div><hr class="task-info-hr">' . $incharge : '';
	
	//担当内容の引き出し
	$incharge_detail = (get_field('acf-incharge-detail',$post_id)) ? '<h2 class="task-detail-head">担当について</h2><div class="task-incharge-detail">' . get_field('acf-incharge-detail') . '</div>' : '';
	
	//メイン画像
	$img_main = get_entry_image(get_field('acf-img-1',$post_id), get_field('acf-img-1-cmnt',$post_id), 'main');
	
	//サブ画像
	$i = 0; $n = 2;
	$img_sub_ar = array();
	while($i < 10){
		if($n === 10){
			//ラスト画像
			$img_last = get_entry_image(get_field('acf-img-10',$post_id), get_field('acf-img-10-cmnt',$post_id), 'last');
		}else{
			$acf_img_num = 'acf-img-' . $n;
			$acf_cmnt_num = 'acf-img-' . $n . '-cmnt';
			$sub_img_tempo = get_entry_image(get_field($acf_img_num,$post_id), get_field($acf_cmnt_num,$post_id));

			if(!empty($sub_img_tempo)){
				$img_sub_ar[$i] = $sub_img_tempo;
				$sub_img_tempo = '';
			}
		}
		$i++; $n++;
	}
	//サブ画像リストを結合
	$img_sub = (is_array($img_sub_ar)) ? '<h2 class="task-detail-head">業務内容</h2>' . "\n" . '<ul class="detail-list">' . implode("\n", $img_sub_ar) . "\n" .'</ul>' : '';
	
	//補足
	$task_note = (get_field('acf-note',$post_id)) ? '<div class="task-note">' . get_field('acf-note') . '</div>' : '';
	
	print $assignment;
	print $strategy;
	the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );
	print $task_info;
	print $incharge_detail;
	print $img_main;
	print $img_sub;
	print $img_last;
	print $task_note;
}
?>
<?php endif; ?>
<!-- meta itemprop="description" content="<?php echo esc_html( wp_strip_all_tags( get_the_excerpt(), true ) ); ?>" / -->
<?php the_content(); ?>
<div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
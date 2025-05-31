<div class="entry__content" itemprop="mainEntityOfPage">
<?php if ( has_post_thumbnail() ) : ?>
<?php
$post_id = get_the_ID();
if(get_field('acf-clinet',$post_id)) {	
	//課題と戦略の引き出し
	$assignment = (get_field('acf-assignment',$post_id)) ? '<div class="task__assignment">' . get_field('acf-assignment') . 
								'</div><span class="task__assignment-arrow"></span>' : '';
	$strategy = (get_field('acf-strategy',$post_id)) ? '<div class="task__strategy">' . get_field('acf-strategy') . '</div>' : '';
	
	//業務情報の引き出し
	$client = (get_field('acf-clinet',$post_id)) ? '<div class="client"><span class="client__label">CL：</span><span class="client__name">' . get_field('acf-clinet',$post_id) . '</span>' . "&nbsp;/&nbsp;" . '<span class="client__type">' . get_field('acf-type',$post_id) . '</span></div>' : '' ;
	$task_url = (get_field('acf-url',$post_id)) ? '<div class="task__url"><a href="' . get_field('acf-url',$post_id) . '" target="_blank" rel="noopener">' . get_field('acf-url',$post_id) . '</a>' : '';
	$year = (get_field('acf-year',$post_id)) ? '<div class="year"><span class="year__value">' . get_field('acf-year',$post_id) . '</span><span class="year__place">' . "&nbsp;/&nbsp;" . get_field('acf-place',$post_id) . '</span></div>' : '';
	$incharge = (get_field('acf-in-charge',$post_id)) ? '<div class="incharge"><div><span class="incharge__label">担当：</span><span class="incharge__name">' . get_field('acf-in-charge',$post_id) . '</span></div>' . $task_url . '</div></div>' : '';
	$task_info = (!empty($incharge)) ? '<div class="task__info">' . $client . $year . '</div><hr class="task__info-hr">' . $incharge : '';
	
	//担当内容の引き出し
	$incharge_detail = (get_field('acf-incharge-detail',$post_id)) ? '<h2 class="task__detail-head">担当について</h2><div class="task__detail">' . get_field('acf-incharge-detail') . '</div>' : '';
	
	//KV画像
	$img_kv = '<div class="entry__image"><img class="entry__image--kv" src="' . get_the_post_thumbnail_url(get_the_ID(),'full') . '" alt="KV"></div>';

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
	$img_sub = (is_array($img_sub_ar)) ? '<h2 class="task__detail-head">業務内容</h2>' . "\n" . '<ul class="detail__container">' . implode("\n", $img_sub_ar) . "\n" .'</ul>' : '';
	
	//補足
	$task_note = (get_field('acf-note',$post_id)) ? '<div class="task__note"><span class="task__note-high-light">' . get_field('acf-note') . '</span></div>' : '';
	
	print $assignment;
	print $strategy;
	print $img_kv;
	print $task_info;
	print $img_main;
	print $img_sub;
	print $img_last;
	print $task_note;
	print $incharge_detail;
}
?>
<?php endif; ?>
</div>
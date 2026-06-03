<div class="entry__content" itemprop="mainEntityOfPage">
<?php if ( has_post_thumbnail() ) : ?>
<?php
$post_id = get_the_ID();
if(get_field('acf-clinet',$post_id)) {

	$acf_type     = get_field('acf-type',$post_id);
	$acf_client   = get_field('acf-clinet',$post_id);
	$acf_year     = get_field('acf-year',$post_id);
	$acf_place    = get_field('acf-place',$post_id);
	$acf_role     = get_field('acf-in-charge',$post_id);
	$acf_url      = get_field('acf-url',$post_id);
	$acf_assign   = get_field('acf-assignment',$post_id);
	$acf_strategy = get_field('acf-strategy',$post_id);
	$acf_detail   = get_field('acf-incharge-detail',$post_id);
	$acf_note     = get_field('acf-note',$post_id);

	/* ── KV（サムネイルを背景にタイトルオーバーレイ）── */
	$thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
	$kv_parts = array_filter([
		$acf_year  ? esc_html($acf_year)  : '',
		$acf_place ? esc_html($acf_place) : '',
		$acf_type  ? esc_html($acf_type)  : '',
	]);
	$kv_sub = $kv_parts
		? '<div class="entry__kv-sub">' . implode(' · ', $kv_parts) . '</div>'
		: '';
	$kv = '<a class="entry__kv glightbox" href="' . esc_url($thumbnail_url) . '" data-gallery="kv">'
		. '<div class="entry__kv-bg" style="background-image:url(' . esc_url($thumbnail_url) . ')"></div>'
		. '<div class="entry__kv-overlay">'
		. '<div class="entry__kv-title">' . esc_html(get_the_title()) . '</div>'
		. $kv_sub
		. '</div>'
		. '</a>';

	/* ── chips ── */
	$chip_type  = $acf_type   ? '<span class="entry__chip">' . esc_html($acf_type)   . '</span>' : '';
	$chip_cl    = $acf_client ? '<span class="entry__chip">CL: ' . esc_html($acf_client) . '</span>' : '';
	$chip_year  = $acf_year   ? '<span class="entry__chip">' . esc_html($acf_year)   . '</span>' : '';
	$chip_place = $acf_place  ? '<span class="entry__chip">' . esc_html($acf_place)  . '</span>' : '';
	$chips = '<div class="entry__chips">' . $chip_type . $chip_cl . $chip_year . $chip_place . '</div>';

	/* ── 課題ブロック（assignment）── */
	$intro = $acf_assign
		? '<div class="task__intro"><p>' . $acf_assign . '</p></div>'
		: '';

	/* ── メイン画像 ── */
	$img_main = get_entry_image(get_field('acf-img-1',$post_id), get_field('acf-img-1-cmnt',$post_id), 'main');

	/* ── STRATEGY セクション ── */
	$section_strategy = '';
	if ($acf_strategy) {
		$section_strategy =
			'<div class="entry__section-head"><span class="entry__section-title">STRATEGY</span></div>'
			. '<div class="task__strategy-box"><p>' . $acf_strategy . '</p></div>';
	}

	/* ── PROJECT INFO セクション ── */
	$info_rows = '';
	if ($acf_client) {
		$info_rows .= '<span class="task__info-label">CLIENT</span><span class="task__info-value">'
			. esc_html($acf_client)
			. ($acf_type ? ' / ' . esc_html($acf_type) : '')
			. '</span>';
	}
	if ($acf_year) {
		$info_rows .= '<span class="task__info-label">YEAR</span><span class="task__info-value">' . esc_html($acf_year) . '</span>';
	}
	if ($acf_place) {
		$info_rows .= '<span class="task__info-label">LOCATION</span><span class="task__info-value">' . esc_html($acf_place) . '</span>';
	}
	if ($acf_role) {
		$info_rows .= '<span class="task__info-label">ROLE</span><span class="task__info-value">' . esc_html($acf_role) . '</span>';
	}
	if (!empty($acf_url) && $acf_url !== 'http://' && $acf_url !== 'https://') {
		$info_rows .= '<span class="task__info-label">URL</span><span class="task__info-value">'
			. '<a href="' . esc_url($acf_url) . '" target="_blank" rel="noopener">' . esc_html($acf_url) . '</a>'
			. '</span>';
	}
	$section_info = $info_rows
		? '<div class="entry__section-head"><span class="entry__section-title">PROJECT INFO</span></div>'
		  . '<div class="task__info">' . $info_rows . '</div>'
		: '';

	/* ── サブ画像（2〜9枚目）+ 最終画像 ── */
	$kv_thumb = get_entry_image($thumbnail_url, get_the_title(), 'list');
	$img_sub_ar = $kv_thumb ? [$kv_thumb] : [];
	for ($n = 2; $n <= 9; $n++) {
		$sub = get_entry_image(get_field('acf-img-' . $n, $post_id), get_field('acf-img-' . $n . '-cmnt', $post_id));
		if (!empty($sub)) {
			$img_sub_ar[] = $sub;
		}
	}
	$img_last = get_entry_image(get_field('acf-img-10', $post_id), get_field('acf-img-10-cmnt', $post_id), 'last');

	/* ── DELIVERABLES セクション ── */
	$section_deliverables = '';
	if (!empty($img_sub_ar) || !empty($img_last)) {
		$section_deliverables = '<div class="entry__section-head"><span class="entry__section-title">DELIVERABLES</span></div>';
		if (!empty($img_sub_ar)) {
			$section_deliverables .= '<ul class="detail__container">' . implode("\n", $img_sub_ar) . '</ul>';
		}
		if (!empty($img_last)) {
			$section_deliverables .= $img_last;
		}
	}

	/* ── ABOUT ROLE セクション ── */
	$section_about = '';
	if ($acf_detail) {
		$section_about = '<div class="entry__section-head"><span class="entry__section-title">ABOUT ROLE</span></div>'
			. '<div class="task__about-box"><p>' . $acf_detail . '</p></div>';
	}

	/* ── 補足 ── */
	$task_note = $acf_note
		? '<div class="task__note"><span class="task__note-high-light">' . $acf_note . '</span></div>'
		: '';

	/* ── 出力 ── */
	print $kv;
	print $chips;
	print $intro;
	print $img_main;
	print $section_strategy;
	print $section_info;
	print $section_deliverables;
	print $section_about;
	print $task_note;
}
?>
<?php endif; ?>
</div>

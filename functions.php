<?php
/**
 * 親テーマと子テーマのスタイルを読み込む
 * @see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme
 */
add_action( 'wp_enqueue_scripts', 'blankslate_child_style' );
function blankslate_child_style()
{
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style') );
}

/**
 * WordPressテーマエディタにJavaScriptファイルタイプを追加
 */
function add_js_to_wp_theme_editor_filetypes_ex($default_types)
{
    $default_types[] = 'js';
    return $default_types;
}
add_filter('wp_theme_editor_filetypes', 'add_js_to_wp_theme_editor_filetypes_ex');

/**
 * アイキャッチ画像（投稿サムネイル）を有効化
 */
add_theme_support('post-thumbnails');

/**
 * アスペクト比を維持した画像サイズを計算して返す
 * 
 * @param string $src 画像のソースパス
 * @param int $num_w 希望する幅
 * @param string $attr 返却形式（'y'でHTML属性、'css'でCSSスタイル、デフォルトで配列）
 * @return string|array 指定された形式の寸法
 */
function get_ratiocal($src = '', $num_w = 0, $attr = 'y')
{
    if (empty($src) || !is_numeric($num_w)) {
        return ($attr == 'y' || $attr == 'css') ? '' : array($num_w, 0);
    }

    $imgsize = getimagesize($src);
    if (!$imgsize || $imgsize[0] <= 0) {
        return ($attr == 'y' || $attr == 'css') ? '' : array($num_w, 0);
    }

    $num_y = $num_w * $imgsize[1] / $imgsize[0];
    switch($attr){
        case 'y':   return ' width="' . $num_w . '" height="' . round($num_y) . '"';
        case 'css': return ' style="width:' . $num_w . 'px; height:' . round($num_y) . 'px;"';
        default:    return array($num_w, round($num_y));
    }
}

/**
 * カテゴリーと追加リンクを含むフッターメニューを生成
 * 
 * @return string フォーマットされたフッターメニューのHTML
 */
function get_footer_menu()
{
    if (!function_exists('get_categories')) {
        return '';
    }

    $categories = get_categories(array(
        'orderby' => 'name',
        'order' => 'DESC',
        'hide_empty' => 0
    ));

    if (empty($categories) || is_wp_error($categories)) {
        return '';
    }
    
    $category_links = array();
    foreach ($categories as $category) {
        if (isset($category->name)) {
            $category_links[] = sprintf(
                '<a class="footer__menu-item" href="%s">%s</a>',
                esc_url(home_url('/works/' . sanitize_title($category->name))),
                esc_html(strtoupper($category->name))
            );
        }
    }
    $foot_cat = '<div class="footer__menu-section"><p class="footer__menu-head">WORKS：</p>[' . "&nbsp;" . implode("&nbsp;|&nbsp;", $category_links) . "&nbsp;" . ']</div>';
    
    $add_cat_array = array('resume', 'about', 'home');
    $cat_add_array = array();
    foreach($add_cat_array as $val){
        $add_url = ($val == 'home') ? '' : sanitize_title($val);
        $cat_add_array[] = '<a class="footer__menu-item" href="' . esc_url(home_url('/' . $add_url)) . '">' . esc_html(strtoupper($val)) . '</a>';
    }
    $foot_cat .= '<div class="footer__menu-section"><p class="footer__menu-head">REST：</p>[' . "&nbsp;" . implode("&nbsp;|&nbsp;", $cat_add_array) . "&nbsp;" . ']</div>';
    
    return $foot_cat;
}

/**
 * 異なる表示タイプ用のエントリー画像を取得してフォーマット
 * 
 * @param string $acf_img_path 画像パス
 * @param string $acf_cmmnt 画像のコメント/説明
 * @param string $type 表示タイプ（'list'または'main'）
 * @return string フォーマットされた画像のHTML
 */
function get_entry_image($acf_img_path='', $acf_cmmnt='', $type='list')
{
    if(!empty($acf_img_path)){
        $path = esc_url($acf_img_path);
        $cmmnt = wp_kses_post($acf_cmmnt);

        switch($type){
            case 'list': $class = ' class="detail__list-image"'; break;
            case 'main': $class = ' class="entry__image--main"'; break;
            case 'last': $class = ' class="detail__list-image--last"'; break;
            default: $class=''; break;
        }

        $img = (!empty($path)) ? '<img' . $class . ' src="' . $path . '" alt="' . esc_attr($cmmnt) . '">' : '';
        
        switch($type){
            case 'list':
                $img = '<a href="' . $path . '" data-gallery="group" data-title="' . esc_attr($cmmnt) . '">' . $img . '</a>';
                $cmmnt = (!empty($cmmnt)) ? '<p class="detail__list-cmmnt">' . $cmmnt . '</p>' : '';
                $img = '<li class="detail__list">' . $img . $cmmnt . '</li>';
                break;
                
            case 'main': 
                $cmmnt = (!empty($cmmnt)) ? '<p class="entry__image-main-cmmnt">' . $cmmnt . '</p>' : '';
                $img = '<div class="entry__image">' . $img . $cmmnt . '</div>';
                break;
				
			case 'last':
                $img = '<a class="detail__last-link" href="' . $path . '" data-gallery="group" data-title="' . esc_attr($cmmnt) . '">' . $img . '</a>';
                $cmmnt = (!empty($cmmnt)) ? '<p class="detail__list-cmmnt">' . $cmmnt . '</p>' : '';
                $img = '<div class="entry__image">' . $cmmnt . $img . '</div>';
				break;
                
            default:
                break;
        }
        return $img;
    }else{
        return '';
    }
}

/**
 * アーカイブタイトルのフォーマットをカスタマイズ
 *
 * @param string $title 元のアーカイブタイトル
 * @return string 修正されたアーカイブタイトル
 */
function custom_archive_title($title = '')
{
    if (is_category()) {
        return 'WORKS: ' . strtoupper(single_cat_title('', false));
    }
    return $title;
}
add_filter('get_the_archive_title', 'custom_archive_title');

/**
 * タグのスタイル付きHTMLリンクを生成する関数
 * 
 * @param array $tags タグオブジェクトの配列
 * @return string|void タグのHTMLリンクを連結した文字列、または空の場合はvoid
 * 
 * 各タグに対して:
 * - タグ名を大文字に変換
 * - タグページへのリンクを生成
 * - HTMLエスケープ処理を実施
 * - aタグでマークアップ
 */
function get_styled_tags($tags = '')
{
    if (empty($tags)) {
        return;
    }
    $result = array();
    foreach ($tags as $tag) {
        if ($tag) {
            $result[] = '<a class="tag__link" href="' . esc_url(home_url('/tags/' . sanitize_title($tag->name))) . '" rel="tag">' . esc_html(strtoupper($tag->name)) . '(' . esc_html($tag->count) . ')</a>';
        }
    }
    return implode('', $result);
}


/**
 * サムネイルの幅を返す
 *
 * @return int サムネイルの幅
 */
function get_thumbnail_width() {
    return 300;
}




/**
 * main.js を </body> 直前に出力する
 */
function blankslate_child_scripts() {
    echo '<script src="' . get_stylesheet_directory_uri() . '/main.js?ver=' . date('U') . '"></script>';
}
add_action('wp_footer', 'blankslate_child_scripts');
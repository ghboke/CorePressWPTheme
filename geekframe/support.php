<?php
/**
 * 功能支持模块
 */
//支持缩略图
global $set;
add_theme_support('post-thumbnails');
set_post_thumbnail_size(480, 300, true);
//链接支持
add_filter('pre_option_link_manager_enabled', '__return_true');

if (function_exists('add_theme_support')) {
//开启导航菜单主题支持
    add_theme_support('top-nav-menus');
//注册一个导航菜单
    register_nav_menus(array(
        'header_menu' => '顶部导航菜单',
        'footer_menu' => '底部导航菜单',
    ));
}
//侧边栏注册
function geekpress_sidebar_reg()
{
    register_sidebar(array(
        'id' => 'index_sidebar',
        'name' => '首页边栏',
        'before_title' => '<h2 class="widget-title">',
        'before_widget' => '<div class="aside-box">',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'id' => 'post_sidebar',
        'name' => '文章边栏',
        'before_title' => '<h2 class="widget-title">',
        'before_widget' => '<div class="aside-box">',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'id' => 'footer_widget',
        'name' => '底部小工具1',
        'before_title' => '<h2 class="footer-widget-title">',
        'before_widget' => '<div class="footer-aside-box">',
        'after_widget' => '</div>'
    ));
}


//移除菜单多余css
add_filter('nav_menu_css_class', 'corePress_css_attributes_filter', 100, 1);
//add_filter('nav_menu_item_id', 'corePress_css_attributes_filter', 100, 1);
//add_filter('page_css_class', 'corePress_css_attributes_filter', 100, 1);
function corePress_css_attributes_filter($classes)
{
    if ($classes) {
        $unset_classes = array('menu-item-type-post_type', 'menu-item-object-page', 'menu-item-object-category', 'menu-item-type-taxonomy', 'menu-item-object-custom', 'menu-item-type-custom', 'page_item', 'menu-item-home');
        foreach ($classes as $k => $class) {
            if (in_array($class, $unset_classes)) unset($classes[$k]);
        }
    }
    return $classes;
}

add_action('widgets_init', 'geekpress_sidebar_reg');

//设置页面注册
add_action('admin_menu', 'geekpress_add_menu');
function geekpress_add_menu()
{
    add_menu_page('主题设置', '主题设置', 'administrator', 'geekpress_setting', 'geekpress_page_setting', 'dashicons-buddicons-topics');
}

function geekpress_page_setting()
{
    require_once FRAMEWORK_PATH . "//page-setting.php";
}


//使用字体图标
/*function corePress_get_dashicons()
{
    wp_enqueue_style('dashicons');
}

add_action('wp_enqueue_scripts', 'corePress_get_dashicons');*/

//禁止转义引号字符
remove_filter('the_content', 'wptexturize'); // 禁止英文引号转义为中文引号
remove_filter('the_content', 'balanceTags'); //禁止对标签自动校正


if ($set['optimization']['removeversion'] === 1) {
    add_filter('script_loader_src', 'mimvp_remove_wp_version_strings');
    add_filter('style_loader_src', 'mimvp_remove_wp_version_strings');
    add_filter('the_generator', 'mimvp_remove_version');
}

function mimvp_remove_wp_version_strings($src)
{
    global $wp_version;
    parse_str(parse_url($src, PHP_URL_QUERY), $query);
    if (!empty($query['ver']) && $query['ver'] === $wp_version) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

function mimvp_remove_version()
{
    return '';
}

if ($set['optimization']['removednsprefetch'] === 1) {
    //去除头部加载dns-prefetch
    remove_action('wp_head', 'wp_resource_hints', 2);
}
if ($set['optimization']['removejson'] === 1) {
//去除json连接
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11);
}
if ($set['optimization']['removemeta'] === 1) {
    //移除前后文、第一篇文章、主页meta信息
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
}
if ($set['optimization']['removefeed'] === 1) {
    //移除feed
    remove_action('wp_head', 'feed_links', 2);//文章和评论feed
    remove_action('wp_head', 'feed_links_extra', 3); //分类等feed
}
if ($set['optimization']['removewpblock'] === 1) {
    //WordPress 5.0+移除 block-library CSS
    add_action('wp_enqueue_scripts', 'fanly_remove_block_library_css', 100);
}
if ($set['optimization']['closegutenberg'] === 1) {
    //WordPress 5.0+移除 古藤堡编辑器
    add_filter('use_block_editor_for_post', '__return_false');

}

function fanly_remove_block_library_css()
{
    wp_dequeue_style('wp-block-library');
}

if ($set['optimization']['closerest'] === 1) {
    //屏蔽 REST API
    add_filter('rest_enabled', '__return_false');
    add_filter('rest_jsonp_enabled', '__return_false');
}
if ($set['optimization']['closeupdate'] === 1) {
    // 禁止 WordPress 检查更新
    /*    remove_action('admin_init', '_maybe_update_core');
        remove_action('admin_init', '_maybe_update_plugins');
        remove_action('admin_init', '_maybe_update_themes');*/

}
if ($set['optimization']['banimgresolving'] === 1) {
    // 禁止大图片压缩
    add_filter('big_image_size_threshold', '__return_false');
}

if ($set['optimization']['closeemoji'] === 1) {
    //禁止emoji
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('embed_head', 'print_emoji_detection_script');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}

if ($set['comment']['encomment'] == 1) {
    function scp_comment_post($incoming_comment)
    {
        $pattern = '/[一-龥]/u';
        // 禁止全英文评论
        if (!preg_match($pattern, $incoming_comment['comment_content'])) {
            wp_die("您的评论中必须包含汉字!");
        }
        return ($incoming_comment);
    }

    add_filter('preprocess_comment', 'scp_comment_post');
}

function CorePress_replace_avatar($avatarUrl)
{
    global $set;
    $avatarUrl = str_replace("http://", "https://", $avatarUrl);
    if ($set['optimization']['gravatarsite'] == 'v2ex') {
        //$avatar = preg_replace(["/[0-9]\.gravatar\.com\/avatar/", "/secure.gravatar\.com\/avatar/"], "cdn.v2ex.com/gravatar", $avatarUrl);
        $avatarUrl = str_replace(array("www.gravatar.com/avatar", "0.gravatar.com/avatar", "1.gravatar.com/avatar", "2.gravatar.com/avatar"), "cdn.v2ex.com/gravatar", $avatarUrl);

    } elseif ($set['optimization']['gravatarsite'] == 'geek') {
        $avatarUrl = str_replace(array("www.gravatar.com/avatar", "0.gravatar.com/avatar", "1.gravatar.com/avatar", "2.gravatar.com/avatar"), "sdn.geekzu.org/avatar", $avatarUrl);
    } elseif ($set['optimization']['gravatarsite'] == 'cn') {
        $avatarUrl = str_replace(array("www.gravatar.com/avatar", "0.gravatar.com/avatar", "1.gravatar.com/avatar", "2.gravatar.com/avatar"), "cn.gravatar.com/avatar", $avatarUrl);
    }
    return $avatarUrl;
}

//print_r($set['optimization']['gravatarsite'] );
add_filter('get_avatar', 'CorePress_replace_avatar');
add_filter('get_avatar_url', 'CorePress_replace_avatar');


add_filter('emoji_svg_url', '__return_false');

show_admin_bar(false);


function copay_footer_admin($text)
{
    global $set;
    if ($set['info']['themeupdate'] == 1) {
        corepress_updateTheme();
        if ($set['info']['newversion'] != THEME_VERSION) {
            $url = '，<a href="' . $set['info']['downurl'] . '" target="_blank">立即更新</a>';
        }
    } else {
        $url = '，已关闭更新';
    }

    return "{$text}<p>CorePress主题，当前版本：" . THEME_VERSIONNAME . "，最新版本：{$set['info']['newversionname']}{$url}</p>";

}

add_filter('admin_footer_text', 'copay_footer_admin');

function corepress_dashboard_help()
{
    global $set;
    ?>
    <p>感谢使用Corepress主题，这些信息可能对您有帮助</p>
    <p>主题官网：<a href="https://www.lovestu.com" target="_blank">https://www.lovestu.com</a></p>
    <p>当前版本：<span><?php echo THEME_VERSIONNAME ?></span></p>
    <?php
}

function corepress_add_dashboard_widgets()
{
    wp_add_dashboard_widget('corepress_dashboard_help', 'CorePress主题', 'corepress_dashboard_help');
}

add_action('wp_dashboard_setup', 'corepress_add_dashboard_widgets');

function corepress_updateTheme()
{
    global $set;
    $lasttime = get_option('corepress_updatetheme');
    if ($lasttime == false) {
        update_option('corepress_updatetheme', time());
    }
    if (time() - $lasttime > 60 * 60) {
        $url = 'http://theme.lovestu.com/version.php?site=' . get_bloginfo('siteurl') . '&n=1&v=' . THEME_VERSION;
        $request = new WP_Http;
        $result = $request->request($url);
        if (!is_wp_error($result)) {
            $json = json_decode($result['body'], true);
            if (isset($json)) {
                $set['info']['newversionname'] = $json['versionname'];
                $set['info']['newversion'] = $json['version'];
                $setdata['option'] = json_encode($set);
                options::getInstance()->saveData($setdata);
            }
        }
        update_option('corepress_updatetheme', time());
    }
}

function corepress_comment_face($incoming_comment)
{
    $pattern = '/\[f=(.*?)\]/';
    $isMatched = preg_match_all($pattern, $incoming_comment, $match);
    if ($isMatched == 0) {
        return $incoming_comment;
    }
    $path = THEME_PATH . "/static/img/face/";
    foreach ($match[1] as $facename) {
        if (file_exists($path . $facename . '.gif')) {
            $incoming_comment = str_replace("[f={$facename}]", '<img src="' . THEME_IMG_PATH . '/face/' . $facename . '.gif" width="30">', $incoming_comment);
        }
    }
    return $incoming_comment;
}


function corepress_loginurl($url)
{
    global $set;
    $query = parse_url($url);
    parse_str($query['query'], $output);
    if ($set['user']['loginpage'] == 1) {
        return $set['user']['lgoinpageurl'] . '?re=' . $output['redirect_to'];
    }
    return $url;
}

function corepress_registerurl($url)
{
    global $set;
    if ($set['user']['regpage'] == 1) {
        return $set['user']['regpageurl'];
    }
    return $url;
}

function corepress_addbutton()
{
//判断用户是否有编辑文章和页面的权限
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }

    //判断用户是否使用可视化编辑器
    if (get_user_option('rich_editing') == 'true') {
        file_load_js('jquery.min.js');
        file_load_js('vue.min.js');
        file_load_css('admin.css');
        file_load_lib('element/index.css', 'css');
        file_load_lib('element/index.js', 'js');
        file_load_js('tools.js');
        file_load_css('editor-window.css');
        file_load_lib('layer/layer.js', 'js');
        file_load_js('editor-functions.js');
        add_filter('mce_external_plugins', 'corepress_add_editor_plugin');
    }
}

function corepress_add_editor_plugin($plugin_array)
{
    $plugin_array['gh-addShortCode'] = THEME_JS_PATH . '/editorButton.js';
    return $plugin_array;
}

function corepress_add_media_button()
{
    echo '<a href="javascript:;"  class="button corepress-btn">CorePress编辑器增强</a>';
}

add_action('media_buttons', 'corepress_add_media_button');
add_action('edit_form_top', 'corepress_addbutton');
add_filter('comment_text', 'corepress_comment_face');
add_filter('comment_text_rss', 'corepress_comment_face');
add_filter('login_url', 'corepress_loginurl', 1);
add_filter('register_url', 'corepress_registerurl', 1);


/** 编辑器取消屏蔽功能
 * @param $initArray
 * @return mixed
 */
function mod_mce($initArray)
{
    $initArray['verify_html'] = false;
    return $initArray;
}

add_filter('tiny_mce_before_init', 'mod_mce');
add_action('add_meta_boxes', 'corepress_add_meta_box');
function corepress_add_meta_box()
{
    add_meta_box('corepress_post_meta', 'CorePress文章设置', 'corepress_meta_box_form', 'page', 'advanced', 'high');
    add_meta_box('corepress_post_meta', 'CorePress文章设置', 'corepress_meta_box_form', 'post', 'advanced', 'high');
}

function corepress_meta_box_form($post)
{
    // 创建临时隐藏表单，为了安全
    wp_nonce_field('corepress_meta_box', 'corepress_meta_box_nonce');
    // 获取之前存储的值
    $corepress_post_meta['set'] = json_decode(get_post_meta($post->ID, 'corepress_post_meta', true), true);

    if (!isset($corepress_post_meta['set']['catalog'])) {
        $corepress_post_meta['set']['catalog'] = 0;
    }
    if (!isset($corepress_post_meta['set']['seo']['open'])) {
        $corepress_post_meta['set']['seo']['open'] = 0;
    }
    if (!isset($corepress_post_meta['set']['seo']['keywords'])) {
        $corepress_post_meta['set']['seo']['keywords'] = '';
    }
    if (!isset($corepress_post_meta['set']['seo']['description'])) {
        $corepress_post_meta['set']['seo']['description'] = '';
    }
    if (!isset($corepress_post_meta['set']['postshow'])) {
        $corepress_post_meta['set']['postshow'] = '0';
    }
    ?>
    <div id="corepress-post-meta">
        <input type="hidden" name="corepress_post_meta" :value="JSON.stringify(set)">
        <div class="set-plane">
            <div class="set-title">
                开启文章目录
            </div>
            <div class="set-object">
                <el-switch
                        v-model="set.catalog"
                        :active-value="1"
                        :inactive-value="0"
                >
                </el-switch>
            </div>
        </div>
        <h3>SEO设置</h3>
        <div class="set-plane">
            <div class="set-title">
                开启独立SEO
            </div>
            <div class="set-object">
                <el-switch
                        v-model="set.seo.open"
                        :active-value="1"
                        :inactive-value="0"
                >
                </el-switch>
            </div>
        </div>
        <div class="set-plane">
            <div class="set-title">
                SEO关键字
            </div>
            <div class="set-object">
                <el-input placeholder="" v-model="set.seo.keywords" size="small">
                </el-input>
            </div>
        </div>
        <div class="set-plane set-plane-nocenter">
            <div class="set-title">
                页面描述
            </div>
            <div class="set-object">
                <el-input
                        type="textarea"
                        :rows="5"
                        placeholder="请输入内容"
                        v-model="set.seo.description">
                </el-input>
            </div>
        </div>
        <h3>显示设置</h3>
        <div class="set-plane">
            <div class="set-title">
                默认列表文章显示方式
            </div>
            <div class="set-object">
                <el-select v-model="set.postshow" placeholder="请选择" size="mini">
                    <el-option
                            v-for="item in postshowlist"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </div>
        </div>
    </div>
    <script>
        var set = JSON.parse('<?php echo json_encode($corepress_post_meta)?>');
        set = set.set;
        var vue = new Vue({
                el: '#corepress-post-meta',
                data: {
                    postshowlist: [{
                        value: '0',
                        label: '默认'
                    },
                        {
                            value: '1',
                            label: '长条横幅'
                        }
                    ],
                    set
                }
            })
        ;
    </script>
    <?php
}

//图片延迟加载
function corePress_lazyload($content)
{
    global $set;
    if ($set['module']['imglazyload'] != 1) {
        return $content;
    }
    /* preg_match_all('/<img .*?class="(.*?)".*?src="(.*?)".*?\>/', $content, $images);
     print_r($images);
     for ($i = 0; $i < count($images[1]); $i++) {
         $replacestr = str_replace($images[1][$i], $images[1][$i] . ' img-lazyload', $images[0][$i]);
         $replacestr = str_replace('src="' . $images[2][$i] . '"', 'data-original="' . $images[2][$i] . '"', $replacestr);

         $content = str_replace($images[0][$i], $replacestr, $content);
     }
     return $content;*/
    preg_match_all('/<img .*?\>/', $content, $images);

    foreach ($images[0] as $item) {
        //跳过base64图片
        if (preg_match('/src="data:(.*?)"/', $item) == 1) {
            continue;
        }
        preg_match('/class="(.*?)"/', $item, $class);
        $need_replace_str = $class[1];
        $replace_str = $class[1] . ' img-lazyload';
        $replace_str = str_replace($need_replace_str, $replace_str, $item);
        $need_replace_str = $item;
        $content = str_replace($need_replace_str, $replace_str, $content);

        preg_match('/src="(.*?)"/', $replace_str, $class);
        $need_replace_str = 'src="' . $class[1] . '"';
        $need_replace_str2 = $replace_str;
        $replace_str = str_replace($need_replace_str, 'data-original="' . $class[1] . '"' . 'src="' . file_get_img_url('loading.png') . '"', $replace_str);

        $content = str_replace($need_replace_str2, $replace_str, $content);
    }
    return $content;

}

add_filter('the_content', 'corePress_lazyload');

//禁止响应式图片
add_filter('wp_calculate_image_srcset', create_function('', 'return false;'));
add_filter('views_users', 'corepress_views_users');



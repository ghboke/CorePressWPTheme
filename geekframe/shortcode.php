<?php
add_shortcode('title-plane', 'post_short_title_plane');
function post_short_title_plane($atts, $content = null, $code = "")
{
    if (isset($atts['title'])) {
        $title = "<p>{$atts['title']}</p>";
    }
    $html = '<div class="title-plane">' . $title . '<div>' . do_shortcode($content) . '</div></div>';
    return $html;
}

add_shortcode('start-plane', 'post_short_start_plane');
function post_short_start_plane($atts, $content = null, $code = "")
{
    /*if (isset($atts['title'])) {
        $title = "<p>{$atts['title']}</p>";
    }*/
    $html = '<div class="start-plane" type="' . $atts['type'] . '"><div>' . do_shortcode($content) . '</div></div>';
    return $html;
}

add_shortcode('icon-url', 'post_short_icon_url');
function post_short_icon_url($atts, $content = null, $code = "")
{
    $wporg_atts = shortcode_atts([
        'target' => '',
        'href' => '',
    ], $atts);
    if ($content == null) {
        $content = $wporg_atts['href'];
    }
    $html = '<a class="icon-url" href="' . $wporg_atts['href'] . '" target="' . $wporg_atts['target'] . '">' . do_shortcode($content) . '</a>';
    return $html;
}

add_shortcode('zd-plane', 'post_short_zd_plane');
function post_short_zd_plane($atts, $content = null, $code = "")
{
    if (isset($atts['title'])) {
        $title = $atts['title'];
    } else {
        $title = "折叠内容，点击展开";
    }
    $html = '<div class="zd-plane"><div class="zd-plane-title">' . $title . '</div><div class="zd-plane-content">' . do_shortcode($content) . '</div></div>';
    return $html;
}

add_shortcode('zd-plane', 'post_short_zd_plane');

add_shortcode('loginshow', 'post_short_loginshow');

function post_short_loginshow($atts, $content = null)
{
    if (islogin()) {
        return $content;
    } else {
        return '<div class="loginshow">本内容需要<a href="' . wp_login_url('//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . '">登录</a>后才能查看</div>';
    }
}

add_shortcode('clickshow', 'post_short_clickshow');
function post_short_clickshow($atts, $content = null)
{
    $wporg_atts = shortcode_atts([
        'type' => '1',
    ], $atts);
    if ($wporg_atts['type'] == 1) {
        return '<span class="clickshow" title="点击显示或隐藏">' . do_shortcode($content) . '</span>';
    } else {
        return '<div class="clickshow clickshow-block" title="点击显示或隐藏">' . do_shortcode($content) . '</div>';
    }
}





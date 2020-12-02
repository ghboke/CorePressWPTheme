<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Referrer" content="origin"/>

<?php
global $set;
if ($set['code']['headcode'] != null) {
    echo base64_decode($set['code']['headcode']);
}
if ($set['code']['css'] != null) {
    echo "<style>" . base64_decode($set['code']['css']) . "</style>";
}

if ($set['routine']['favicon'] != null) {
    ?>
    <link rel="icon" href="<?php echo $set['routine']['favicon'] ?>" type="image/x-icon"/>
    <?php
}
?>
<style>
    :root {
        --Maincolor: <?php echo $set['theme']['themeColor']?> !important;
        --MaincolorHover: <?php echo $set['theme']['themeHoverColor']?> !important;
        --fontSelectedColor: <?php echo $set['theme']['fontSelectedColor']?> !important;
    }
</style>
<?php


wp_head();
file_load_css('main-mobile.css');
file_load_css('main.css');
file_load_lib('fontawesome5/css/all.min.css', 'css');
file_load_js('jquery.min.js');

if ($set['module']['imglazyload'] == 1) {
    file_load_js('jquery.lazyload.min.js');
}
file_load_js('tools.js');
if (is_home()) {
    file_load_lib('swiper/swiper.min.css', 'css');
    file_load_lib('swiper/swiper.min.js', 'js');
}

global $set;
if (is_home()) {
    if ($set['seo']['openseo'] == 1) {
        if ($set['seo']['indextitle'] != '') {
            $title = $set['seo']['indextitle'];

        } else {
            $title = get_bloginfo('name');
        }
    } else {
        $title = get_bloginfo('name');
    }
} elseif (is_single() || is_page()) {
    if ($set['post']['imgradius'] == 1) {
        ?>
        <style>
            .post-content-post img {
                border-radius: 10px;
            }
        </style>
        <?php
    }
    if ($set['post']['imgshadow'] == 1) {
        ?>
        <style>
            .post-content-post img {
                box-shadow: 0 0 5px 0 rgba(0, 0, 0, .1);
            }
        </style>
        <?php
    }
    file_load_js('qrcode.min.js');
    file_load_js('clipboard.min.js');
    file_load_css('comment-module.css');
    file_load_css('post-content.css');
    file_load_lib('fancybox/jquery.fancybox.min.css', 'css');
    file_load_lib('fancybox/jquery.fancybox.min.js', 'js');
    file_load_lib('fancybox/init.js', 'js');
    if ($set['module']['highlight'] == 1) {
        file_load_lib('highlight/highlight.min.js', 'js');

        if ($set['module']['highlighttheme'] == 1) {
            file_load_lib('highlight/style/corepress-dark.css', 'css');
        } else {
            file_load_lib('highlight/style/corepress.css', 'css');
        }

    }

    if ($set['seo']['openseo'] == 1) {
        $delimiter = $set['seo']['title_delimiter'];
        if ($set['seo']['titlestyle'] == 'site_title') {
            $title = get_bloginfo('name') . $delimiter . get_the_title();
        } elseif ($set['seo']['titlestyle'] == 'title_site') {
            $title = get_the_title() . $delimiter . get_bloginfo('name');
        } else {
            $title = get_the_title();
        }
    } else {
        $title = get_the_title();
    }

} elseif (is_category()||is_tag()) {
    $delimiter = $set['seo']['title_delimiter'];
    if ($set['seo']['openseo'] == 1) {
        if ($set['seo']['titlestyle'] == 'site_title') {
            $title = get_bloginfo('name') . $delimiter . single_cat_title('', false);
        } elseif ($set['seo']['titlestyle'] == 'title_site') {
            $title = single_cat_title('', false) . $delimiter . get_bloginfo('name');
        } else {
            $title = single_cat_title('', false);
        }
    } else {
        $title = single_cat_title('', false);
    }

}  else {

    if ($set['seo']['openseo'] == 1) {
        $delimiter = $set['seo']['title_delimiter'];
        $title = wp_title($delimiter, false, 'right');
    } else {
        $title = wp_title('&raquo;', false, 'right');
    }
}
echo "<title>{$title}</title>";
$keywords = '';
$description = '';
if (is_home()) {
    if ($set['seo']['description'] != null) {
        $description = $set['seo']['description'];
    } else {
        $description = get_bloginfo('description');
    }

    if ($set['seo']['keyword'] != null) {
        $keywords = $set['seo']['keyword'];
    }

} else if (is_single() || is_page()) {
    global $post;
    global $corepress_post_meta;
    $corepress_post_meta = json_decode(get_post_meta($post->ID, 'corepress_post_meta', true), true);
    if ($corepress_post_meta['seo']['open'] == 1) {
        $description = $corepress_post_meta['seo']['description'];
        $keywords = $corepress_post_meta['seo']['keywords'];
    } else {
        $description = str_replace("\n", "", mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));
        $tags = wp_get_post_tags($post->ID);
        foreach ($tags as $tag) {
            $keywords = $keywords . $tag->name . ", ";
        }
        $keywords = rtrim($keywords, ', ');
    }

} elseif (is_tag()) {
    // 标签的description可以到后台 - 文章 - 标签，修改标签的描述
    $description = tag_description();
    $keywords = single_tag_title('', false);
}
$description = trim(strip_tags($description));
$keywords = trim(strip_tags($keywords));
if ($set['seo']['openseo'] == 1) {
    if (post_password_required() == false) {
        ?>
        <meta name="keywords" content="<?php echo $keywords; ?>"/>
        <meta name="description" content="<?php echo $description; ?>"/>
        <?php
    }
}
?>





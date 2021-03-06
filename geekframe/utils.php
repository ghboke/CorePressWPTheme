<?php
/**
 * wordpress实用功能
 */


function file_load_js($path)
{
    echo '<script src="' . THEME_JS_PATH . '/' . $path . '?v=' . THEME_VERSIONNAME . '"></script>';
}

function load_js_parameter($name, $arr)
{
    echo '<script>var ' . $name . '=JSON.parse(' . "'" . json_encode($arr) . "'" . ')</script>';
}

function file_load_img($path)
{
    echo "<img src=\"" . THEME_IMG_PATH . "/{$path}\">";
}

function file_get_img_url($path)
{
    return THEME_IMG_PATH . "/" . $path;
}

function file_echo_svg($path)
{

    global $wp_filesystem;
    $svg = $wp_filesystem->get_contents(THEME_PATH . '/static/img/' . $path);
    print_r($svg);
    //readfile(THEME_PATH . '/static/img/' . $path);

}

function file_load_face()
{

    $files = scandir(THEME_PATH . "/static/img/face");
    $html = null;
    foreach ($files as $v) {
        /* if(is_file($v)){
             $fileItem[] = $v;
         }*/
        if (pathinfo($v, PATHINFO_EXTENSION) == 'gif') {
            $html = '<img class="img-pace" src="' . THEME_IMG_PATH . '/face/' . $v . '" width="30" facename="' . basename($v, ".gif") . '">' . $html;
        }

    }
    return $html;
}

function file_load_css($path)
{

    echo '<link rel="stylesheet" href="' . THEME_CSS_PATH . '/' . $path . '?v=' . THEME_VERSIONNAME . '">';
}

function file_load_lib($path, $type)
{
    if ($type == 'css') {
        echo '<link rel="stylesheet" href="' . THEME_LIB_PATH . '/' . $path . '?v=' . THEME_VERSIONNAME . '">';
    } elseif ($type == 'js') {
        echo '<script src="' . THEME_LIB_PATH . '/' . $path . '"></script>';
    }
}

function file_load_component($name)
{
    require_once(THEME_PATH . "/component/{$name}");
}

function islogin()
{
    return is_user_logged_in();
}

function loginAndBack($url = null)
{
    if ($url == null) {
        return wp_login_url('//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    } else {
        return wp_login_url($url);

    }

}

function corepress_get_user_nickname($user_id = null)
{
    if ($user_id == null) {
        $currentUser = wp_get_current_user();
        $name = $currentUser->display_name;
    } else {
        $user = get_userdata($user_id);
        $name = $user->display_name;
    }
    return $name;
}

function corepress_get_avatar_url($email = null, $size = 60)
{

    if ($email == null) {
        $currentUser = wp_get_current_user();
        $avatarurl = get_avatar_url($currentUser->user_email, array('size' => $size));
    } else {
        $avatarurl = get_avatar_url($email, array('size' => $size));
    }

    return $avatarurl;

}

function isadmin($user_id = null)
{
    if ($user_id == null) {
        $currentUser = wp_get_current_user();
        $roles = $currentUser->roles;

    } else {
        $user = get_userdata($user_id);
        $roles = $user->roles;
    }

    if (!empty($roles) && in_array('administrator', $roles)) {
        return true;
    } else {
        return false;  // 非管理员
    }

}

function diffBetweenTwoDay($pastDay)
{
    $timeC = time() - strtotime($pastDay);
    $dateC = round((strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', strtotime($pastDay)))) / 60 / 60 / 24);
    if ($timeC <= 3 * 60) {
        $dayC = '刚刚';
    } elseif ($timeC > 3 * 60 && $timeC <= 5 * 60) {
        $dayC = '3分钟前';
    } elseif ($timeC > 5 * 60 && $timeC <= 10 * 60) {
        $dayC = '5分钟前';
    } elseif ($timeC > 10 * 60 && $timeC <= 30 * 60) {
        $dayC = '10分钟前';
    } elseif ($timeC > 30 * 60 && $timeC <= 60 * 60) {
        $dayC = '30分钟前';
    } elseif ($timeC > 60 * 60 && $timeC <= 120 * 60) {
        $dayC = '1小时前';
    } elseif ($timeC > 120 * 60 && $dateC == 0) {
        $dayC = '今天';
    } elseif ($dateC == 1) {
        $dayC = '昨天';
    } else {
        $dayC = date('Y-m-d', strtotime($pastDay));
    }
    return $dayC;
}

if (!function_exists('utf8_excerpt')) :
    function utf8_excerpt($str, $len)
    {
        $str = strip_tags(str_replace(array("\n", "\r"), ' ', $str));
        if (function_exists('mb_substr')) {
            $excerpt = mb_substr($str, 0, $len, 'utf-8');
        } else {
            preg_match_all("/[x01-x7f]|[xc2-xdf][x80-xbf]|xe0[xa0-xbf][x80-xbf]|[xe1-xef][x80-xbf][x80-xbf]|xf0[x90-xbf][x80-xbf][x80-xbf]|[xf1-xf7][x80-xbf][x80-xbf][x80-xbf]/", $str, $ar);
            $excerpt = join('', array_slice($ar[0], 0, $len));
        }

        if (trim($str) != trim($excerpt)) {
            $excerpt .= '...';
        }
        return $excerpt;
    }
endif;

function format_date($time)
{
    global $options, $post;
    $p_id = isset($post->ID) ? $post->ID : 0;
    $q_id = get_queried_object_id();
    $single = $p_id == $q_id && is_single();
    if (isset($options['time_format']) && $options['time_format'] == '0') {
        return date(get_option('date_format') . ($single ? ' ' . get_option('time_format') : ''), $time);
    }
    $t = current_time('timestamp') - $time;
    $f = array(
        '86400' => '天',
        '3600' => '小时',
        '60' => '分钟',
        '1' => '秒'
    );
    if ($t == 0) {
        return '1秒前';
    } else if ($t >= 604800 || $t < 0) {
        return date(get_option('date_format') . ($single ? ' ' . get_option('time_format') : ''), $time);
    } else {
        foreach ($f as $k => $v) {
            if (0 != $c = floor($t / (int)$k)) {
                return $c . $v . '前';
            }
        }
    }
}

function get_share_url($type, $title, $summary)
{
    global $set;
    if ($set['seo']['description'] != null) {
        $description = $set['seo']['description'];
    } else {
        $description = get_bloginfo('description');
    }
    $url = urlencode(get_bloginfo('url'));
    if ($type == 'qq') {
        return 'https://connect.qq.com/widget/shareqq/index.html?url=' . $url . '&title=' . urlencode($title) . '&source=' . urlencode(get_bloginfo('name')) . '&desc=' . urlencode($description) . '&pics=&summary=' . urlencode($summary);
    } else if ($type == 'weibo') {
        return 'https://service.weibo.com/share/share.php?url=' . $url . '&title=' . urlencode($summary) . '&pic=&appkey=&searchPic=true';
    } else if ($type = 'qzone') {
        return 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' . $url . '&title=' . urlencode($title) . '&pics=&summary=' . urlencode($summary);
    }
}

function corepress_replace_copyright($str)
{
    global $post;
    $author_name = get_the_author();
    $post_url = get_permalink();

    $str = str_replace('<#username#>', $author_name, $str);
    $str = str_replace('<#url#>', $post_url, $str);

    return $str;
}

function corepress_jmp_message($message, $jumpUrl)
{
    global $set;
    ?>
    <!doctype html>
    <html lang="zh">
    <head>
        <?php get_header(); ?>
    </head>
    <body>
    <?php
    file_load_css('login-plane.css');
    ?>
    <div id="app" class="login-background">
        <header>
            <div class="header-main-plane">
                <div class="header-main container">
                    <?php
                    get_template_part('component/nav-header');
                    ?>
                </div>
            </div>
        </header>
        <div class="header-zhanwei" style="min-height: 80px;width: 100%;"></div>
        <main class="container">
            <div class="html-main"
                 style="background: #fff;padding: 20px;height: 100%;margin-bottom: 20px;font-size: 20px">
                <div>
                    <?php echo $message ?>
                    <div><a href="<?php echo $jumpUrl ?>">点击这儿</a>直接跳转</div>
                </div>
            </div>
        </main>
        <script>
            setTimeout(function () {
                location.replace('<?php echo $jumpUrl?>')
            }, 3000)</script>
        <footer>
            <?php
            wp_footer();
            get_footer(); ?>
        </footer>
    </div>
    </body>
    </html>
    <?php
}

function curPageURL()
{
    $pageURL = 'http';

    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    $this_page = $_SERVER["REQUEST_URI"];

    // 只取 ? 前面的内容
    if (strpos($this_page, "?") !== false) {
        $this_pages = explode("?", $this_page);
        $this_page = reset($this_pages);
    }

    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $this_page;
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $this_page;
    }
    return $pageURL;
}

/**
 *参数验证
 */
function parameter_verification($arr, $type = 0)
{
    $re_arry = array();
    foreach ($arr as $item) {
        if ($type == 1) {
            if (!isset($_POST[$item])) {
                $json['code'] = 0;
                $json['msg'] = '参数错误';
                wp_die(json_encode($json));
            } else {
                $re_arry[$item] = $_POST[$item];
            }
        } else {
            if (!isset($_GET[$item])) {
                $json['code'] = 0;
                $json['msg'] = '参数错误';
                wp_die(json_encode($json));
            } else {
                $re_arry[$item] = $_GET[$item];
            }
        }

    }
    return $re_arry;
}

function ajax_die($msg, $code = 0)
{
    $json['code'] = $code;
    $json['msg'] = $msg;
    wp_die(json_encode($json));
}

function is_wx_qq()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($user_agent, 'MicroMessenger') == false && strpos($user_agent, 'QQ/') == false) {
        return false;
    } else {
        return true;
    }
}

function loadiconfont_by_cdn()
{
    global $set;
    if ($set['optimization']['iconfontcdn'] == 'JsDelivr') {
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/ghboke/corepresscdn@master/static/lib/fontawesome5pro/css/all.min.css?v=' . THEME_VERSIONNAME . '">';

    } else {
        file_load_lib('fontawesome5/css/all.min.css', 'css');
    }

}

function corepress_pinyin_long($zh)
{
    //获取整条字符串汉字拼音首字母
    $ret = "";
    $zh = preg_replace('# #', '', $zh);
    $s1 = iconv("UTF-8", "gb2312", $zh);
    $s2 = iconv("gb2312", "UTF-8", $s1);
    if ($s2 == $zh) {
        $zh = $s1;
    }
    for ($i = 0; $i < strlen($zh); $i++) {
        $s1 = substr($zh, $i, 1);
        $p = ord($s1);
        if ($p > 160) {
            $s2 = substr($zh, $i++, 2);
            $ret .= corepress_getFirstPing($s2);
        } else {
            $ret .= $s1;
        }
    }
    return $ret;
}

function replace_symbol($str)
{
    $str = str_replace('？', '', $str);
    $str = str_replace('`', '', $str);
    $str = str_replace('·', '', $str);
    $str = str_replace('~', '', $str);
    $str = str_replace('!', '', $str);
    $str = str_replace('！', '', $str);
    $str = str_replace('@', '', $str);
    $str = str_replace('#', '', $str);
    $str = str_replace('$', '', $str);
    $str = str_replace('￥', '', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('^', '', $str);
    $str = str_replace('……', '', $str);
    $str = str_replace('&', '', $str);
    $str = str_replace('*', '', $str);
    $str = str_replace('(', '', $str);
    $str = str_replace(')', '', $str);
    $str = str_replace('（', '', $str);
    $str = str_replace('）', '', $str);
    $str = str_replace('-', '', $str);
    $str = str_replace('_', '', $str);
    $str = str_replace('——', '', $str);
    $str = str_replace('+', '', $str);
    $str = str_replace('=', '', $str);
    $str = str_replace('|', '', $str);
    $str = str_replace('\\', '', $str);
    $str = str_replace('[', '', $str);
    $str = str_replace(']', '', $str);
    $str = str_replace('【', '', $str);
    $str = str_replace('】', '', $str);
    $str = str_replace('{', '', $str);
    $str = str_replace('}', '', $str);
    $str = str_replace(';', '', $str);
    $str = str_replace('；', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace('：', '', $str);
    $str = str_replace('\'', '', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('“', '', $str);
    $str = str_replace('”', '', $str);
    $str = str_replace(',', '', $str);
    $str = str_replace('，', '', $str);
    $str = str_replace('<', '', $str);
    $str = str_replace('>', '', $str);
    $str = str_replace('《', '', $str);
    $str = str_replace('》', '', $str);
    $str = str_replace('.', '', $str);
    $str = str_replace('。', '', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace('、', '', $str);
    $str = str_replace('?', '', $str);
    $str = str_replace('？', '', $str);
    return trim($str);
}

/**
 * 获取首字符拼音首字母
 * 判断是否为汉字 !preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $s0)
 * 已知 “泸”，无法识别
 */
function corepress_getFirstPing($str)
{
    $s0 = mb_substr($str, 0, 1, 'utf-8');
    $fchar = ord($s0[0]);
    if ($fchar >= ord("A") and $fchar <= ord("z")) return strtoupper($s0[0]);
    $s1 = iconv("UTF-8", "gb2312", $s0);
    $s2 = iconv("gb2312", "UTF-8", $s1);
    if ($s2 == $s0) {
        $s = $s1;
    } else {
        $s = $s0;
    }
    $asc = ord($s[0]) * 256 + ord($s[0]) - 65536;
    if ($asc >= -20319 && $asc <= -20284) return "A";
    if ($asc >= -20283 && $asc <= -19776) return "B";
    if ($asc >= -19775 && $asc <= -19219) return "C";
    if ($asc >= -19218 && $asc <= -18711) return "D";
    if ($asc >= -18710 && $asc <= -18527) return "E";
    if ($asc >= -18526 && $asc <= -18240) return "F";
    if ($asc >= -18239 && $asc <= -17923) return "G";
    if ($asc >= -17922 && $asc <= -17418) return "H";
    if ($asc >= -17922 && $asc <= -17418) return "I";
    if ($asc >= -17417 && $asc <= -16475) return "J";
    if ($asc >= -16474 && $asc <= -16213) return "K";
    if ($asc >= -16212 && $asc <= -15641) return "L";
    if ($asc >= -15640 && $asc <= -15166) return "M";
    if ($asc >= -15165 && $asc <= -14923) return "N";
    if ($asc >= -14922 && $asc <= -14915) return "O";
    if ($asc >= -14914 && $asc <= -14631) return "P";
    if ($asc >= -14630 && $asc <= -14150) return "Q";
    if ($asc >= -14149 && $asc <= -14091) return "R";
    if ($asc >= -14090 && $asc <= -13319) return "S";
    if ($asc >= -13318 && $asc <= -12839) return "T";
    if ($asc >= -12838 && $asc <= -12557) return "W";
    if ($asc >= -12556 && $asc <= -11848) return "X";
    if ($asc >= -11847 && $asc <= -11056) return "Y";
    if ($asc >= -11055 && $asc <= -10247) return "Z";
    return $s0;
}

function the_breadcrumb()
{
    echo '<span class="corepress-crumbs-ul">';
    if (!is_home()) {
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        echo '<i class="fas fa-home"></i> 主页';
        echo "</a></li>";
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li><li> ');
            if (is_single()) {
                echo "</li>";
            }
        } elseif (is_page()) {
            echo '<li>';
            echo the_title();
            echo '</li>';
        }
    } elseif (is_tag()) {
        single_tag_title();
    } elseif (is_day()) {
        echo "<li>Archive for ";
        the_time('F jS, Y');
        echo '</li>';
    } elseif (is_month()) {
        echo "<li>Archive for ";
        the_time('F, Y');
        echo '</li>';
    } elseif (is_year()) {
        echo "<li>Archive for ";
        the_time('Y');
        echo '</li>';
    } elseif (is_author()) {
        echo "<li>Author Archive";
        echo '</li>';
    } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
        echo "<li>Blog Archives";
        echo '</li>';
    } elseif (is_search()) {
        echo "<li>Search Results";
        echo '</li>';
    }
    echo '</span>';
}

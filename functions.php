<?php
define('THEME_NAME', 'CorePress');
define('THEME_VERSION', 31);
define('THEME_DOWNURL', 'https://www.lovestu.com');
define('THEME_VERSIONNAME', '4.0');
define('THEME_PATH', get_template_directory());
define('THEME_STATIC_PATH', get_template_directory_uri() . '/static');
define('THEME_CSS_PATH', THEME_STATIC_PATH . '/css');
define('THEME_JS_PATH', THEME_STATIC_PATH . '/js');
define('THEME_LIB_PATH', THEME_STATIC_PATH . '/lib');
define('THEME_IMG_PATH', THEME_STATIC_PATH . '/img');
define('FRAMEWORK_PATH', THEME_PATH . '/geekframe');
define('FRAMEWORK_URI', get_template_directory_uri() . '/geekframe');
define('AJAX_URL', admin_url('admin-ajax.php'));
require_once(FRAMEWORK_PATH . '/options.php');
$set = options::getInstance()->getdata();
require_once(FRAMEWORK_PATH . '/utils.php');
require_once(FRAMEWORK_PATH . '/support.php');
require_once(FRAMEWORK_PATH . '/users.php');
require_once(FRAMEWORK_PATH . '/ajax.php');

require_once(FRAMEWORK_PATH . '/comment-pro.php');
require_once(THEME_PATH . '/widgets/comments.php');
require_once(THEME_PATH . '/widgets/author.php');
require_once(THEME_PATH . '/widgets/hot-post.php');

require_once(FRAMEWORK_PATH . '/shortcode.php');
add_editor_style('static/css/editor-style.css');
error_reporting(0);

require_once(ABSPATH . 'wp-admin/includes/file.php');
WP_Filesystem();
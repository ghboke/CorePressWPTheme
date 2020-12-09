<?php
function CorePress_saveThemeset()
{
    global $set;
    $data['code'] = 200;
    $setdata['version'] = THEME_VERSION;
    $json = json_decode(file_get_contents('php://input'), true);
    if ($json) {
        $setdata['option'] = base64_decode($json['save']);
        if (options::saveData($setdata)) {
            $data['code'] = 1;
        } else {
            $data['code'] = 0;
        }
    } else {
        $data['code'] = 503;
    }
    wp_die(json_encode($data));
}

function CorePress_login()
{
    global $set;
    session_start();
    $array = array();
    $array['user_login'] = $_POST['user'];
    $array['user_password'] = $_POST['pass'];
    $array['remember'] = $_POST['remember'];
    $code = $_POST['code'];
    if ($set['user']['VerificationCode'] == 1) {
        if (strtoupper($code) != $_SESSION['authcode']) {
            $json['code'] = 0;
            $json['msg'] = '登录失败，验证码错误';
            wp_die(json_encode($json));
        }
    }
    $user = wp_signon($array);

    if (is_wp_error($user)) {
        $json['code'] = 0;
        $json['msg'] = '登录失败，账号或密码错误';
    } else {
        $userid = $user->data->ID;
        $json['code'] = 1;
        $json['msg'] = '登录成功';
    }
    wp_die(json_encode($json));
}

function CorePress_reguser()
{
    global $set;
    session_start();
    $array = array();
    $array['user_login'] = $_POST['user'];
    $array['user_pass'] = $_POST['pass'];
    $array['user_nicename'] = $_POST['user'];
    $array['user_email'] = $_POST['mail'];
    $code = $_POST['code'];

    if ($set['user']['regpageVerificationCode'] == 1) {
        if (strtoupper($code) != $_SESSION['authcode']) {
            $json['code'] = 0;
            $json['msg'] = '注册失败，验证码错误';
            wp_die(json_encode($json));
        }
    }

    if (email_exists($array['user_email']) != false) {
        $json['code'] = 0;
        $json['msg'] = '注册失败，邮箱已存在!';
        wp_die(json_encode($json));
    }
    if (username_exists($array['user_login']) != null) {
        $json['code'] = 0;
        $json['msg'] = '注册失败，用户名已存在!';
        wp_die(json_encode($json));
    }
    $res = wp_insert_user($array);
    if ($res) {
        if ($set['user']['regapproved'] == 'approved') {
            $json['code'] = 1;
            $json['msg'] = '注册成功!';
        } else if ($set['user']['regapproved'] == 'manualapprov') {
            //update_user_meta($res, 'corepress_approve', 1);
            $json['code'] = 2;
            $json['msg'] = '注册成功!请等待管理员审核后方可登陆';
        }
        wp_die(json_encode($json));
    } else {
        $json['code'] = 0;
        $json['msg'] = '注册失败!';
        wp_die(json_encode($json));
    }
}

function CorePress_edit_window_html()
{
    ?>

    <div id="corepress-edit-window">
        <div class="corepress-edit-window">
            <h3>短代码</h3>
            <button class="el-button el-button--default el-button--small corepress-edit-window-btn"
                    onclick="addshortcode('title-plane')">标题面板
            </button>
            <button class="el-button el-button--default el-button--small corepress-edit-window-btn"
                    onclick="addshortcode('start-plane')">标星面板
            </button>
            <button class="el-button el-button--default el-button--small corepress-edit-window-btn"
                    onclick="addshortcode('icon-url')">图标超链接
            </button>
            <button class="el-button el-button--default el-button--small corepress-edit-window-btn"
                    onclick="addshortcode('zd-plane')">折叠面板
            </button>
            <button class="el-button el-button--default el-button--small corepress-edit-window-btn"
                    onclick="addshortcode('loginshow')">登录可见
            </button>
            <button class="el-button el-button--default el-button--small corepress-edit-window-btn"
                    onclick="addshortcode('clickshow')">点击可见
            </button>

            <h3>功能拓展</h3>
            <button class="el-button el-button--default el-button--small corepress-edit-window-btn"
                    onclick="addshortcode('corepress-code')">代码高亮
            </button>

            <button class="el-button el-button--default el-button--small corepress-edit-window-btn"
                    onclick="addshortcode('corepress-code-line')">行内代码
            </button>
            <p>
                <a href="https://www.yuque.com/applek/corepress/shortcode" target="_blank">短代码相关说明</a>
            </p>
        </div>
    </div>
    <?php
    wp_die();
}

function corepress_save_post_meta($post_id)
{
    // 安全检查
    // 检查是否发送了一次性隐藏表单内容
    if (!isset($_POST['corepress_meta_box_nonce'])) {
        return;
    }
    // 判断隐藏表单的值与之前是否相同
    if (!wp_verify_nonce($_POST['corepress_meta_box_nonce'], 'corepress_meta_box')) {
        return;
    }
    // 判断该用户是否有权限
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    // 判断 Meta Box 是否为空
    if (!isset($_POST['corepress_post_meta'])) {
        return;
    }
    update_post_meta($post_id, 'corepress_post_meta', $_POST['corepress_post_meta']);
}

function corepress_resetuser()
{
    global $set;
    if (isset($_GET['pwd'])) {
        $pwd = $_GET['pwd'];
        if ($pwd == $set['user']['reuserpwd']) {
            $set['user']['loginpage'] = 0;
            $setdata['option'] = json_encode($set);
            $setdata['version'] = THEME_VERSION;
            options::saveData($setdata);

            wp_die('已关闭自定义登录页面');
        } else {

            wp_die('密码错误');

        }
    } else {
        wp_die('参数错误');
    }
}

function jiemi()
{
    $code = $_GET['code'];
    print_r(json_decode(options::unlock($code)));
    wp_die();

}

add_action('wp_ajax_nopriv_jm', 'jiemi');

add_action('wp_ajax_nopriv_resetuser', 'corepress_resetuser');
add_action('wp_ajax_nopriv_corepress_login', 'CorePress_login');
add_action('wp_ajax_nopriv_corepress_reguser', 'CorePress_reguser');
add_action('wp_ajax_corepress_reguser', 'CorePress_reguser');

add_action('wp_ajax_save', 'CorePress_saveThemeset');//管理员调用
add_action('wp_ajax_geteditwindowhtml', 'CorePress_edit_window_html');//管理员调用
add_action('save_post', 'corepress_save_post_meta');

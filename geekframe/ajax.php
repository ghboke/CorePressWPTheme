<?php
function CorePress_saveThemeset()
{
    global $set;
    $data['code'] = 200;
    $setdata['version'] = THEME_VERSION;
    global $wp_filesystem;
    $json = json_decode($wp_filesystem->get_contents('php://input'), true);
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
        $recode = CorePress_useractive('email', $array['user_email']);
        if ($recode == 1) {
            $json['code'] = 0;
            $json['msg'] = '注册失败，邮箱已存在!';
            wp_die(json_encode($json));
        } else if ($recode == 2) {
            $json['code'] = 0;
            $json['msg'] = '用户已存在，请前往激活!';
            wp_die(json_encode($json));
        }

    }
    if (username_exists($array['user_login']) != null) {
        $recode = CorePress_useractive('user_login', $array['user_login']);

        if ($recode == 1) {
            $json['code'] = 0;
            $json['msg'] = '注册失败，用户名已存在!';
            wp_die(json_encode($json));
        } else if ($recode == 2) {
            $json['code'] = 0;
            $json['msg'] = '用户已存在，请前往激活!';
            wp_die(json_encode($json));
        }
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
        } else if ($set['user']['regapproved'] == 'mailapproved') {
            $json['code'] = 2;
            $json['msg'] = '注册成功!我们给您邮箱发送了一封激活邮件，请按照邮件提示激活用户';
        }
        wp_die(json_encode($json));
    } else {
        $json['code'] = 0;
        $json['msg'] = '注册失败!';
        wp_die(json_encode($json));
    }
}


/**
 * @param $field
 * @param $text
 * @return int 返回1已存在激活用户,0用户失效，重新注册；2用户已注册还没激活
 */
function CorePress_useractive($field, $text)
{
    //查看是否激活并且重新注册
    $userObj = get_user_by($field, $text);

    if (get_user_meta($userObj->ID, 'corepress_approve', true) == 0) {
        return 1;
    } else {

        $activation_key = $userObj->user_activation_key;

        if ($activation_key != null && strpos($activation_key, ":") != false) {
            $arr = explode(":", $activation_key);
            $time = $arr[0];
            $activation_key = $arr[1];
            $nowtime = time();

            if (($nowtime - $time) > 86400 || ($nowtime - $time) < -86400) {
                wp_delete_user($userObj->ID);
                return 0;
            } else {
                return 2;
            }
        }
    }
    return 1;
}

function CorePress_edit_window_html()
{
    file_load_js('jquery.min.js');
    ?>
    <div id="corepress-edit-window">
        <div class="corepress-edit-window">
            <h3>短代码</h3>
            <div class="short-plane-list">
                <button class="add-shortcode-btn el-button el-button--default el-button--small corepress-edit-window-btn"
                        shortcode="title-plane">标题面板
                </button>
                <button class="add-shortcode-btn el-button el-button--default el-button--small corepress-edit-window-btn"
                        shortcode="icon-url">图标超链接
                </button>
                <button class="add-shortcode-btn el-button el-button--default el-button--small corepress-edit-window-btn"
                        shortcode="zd-plane">折叠面板
                </button>
                <button class="add-shortcode-btn el-button el-button--default el-button--small corepress-edit-window-btn"
                        shortcode="loginshow">登录可见
                </button>
                <button class="add-shortcode-btn el-button el-button--default el-button--small corepress-edit-window-btn"
                        shortcode="clickshow">点击可见
                </button>
                <button class="add-shortcode-btn el-button el-button--default el-button--small corepress-edit-window-btn"
                        shortcode="pwdshow">密码可见
                </button>
            </div>
            <div class="short-plane">
                <div>标星面板：
                    <select class="select-start-plane">
                        <option value="1">黄色</option>
                        <option value="2">蓝色</option>
                        <option value="3">红色</option>
                        <option value="4">灰色</option>
                    </select>
                </div>
                <button class="add-shortcode-btn el-button el-button--default el-button--small corepress-edit-window-btn"
                        shortcode="start-plane">插入标星面板
                </button>
            </div>
            <div class="short-plane">
                <div>提示面板：
                    <select class="select-c-alert">
                        <option value="info">默认</option>
                        <option value="success">成功</option>
                        <option value="warning">警告</option>
                        <option value="error">错误</option>
                    </select>
                </div>
                <button class="add-shortcode-btn el-button el-button--default el-button--small corepress-edit-window-btn"
                        shortcode="c-alert">插入提示面板
                </button>
            </div>

            <div class="short-plane">
                <div>下载面板：
                    <select class="select-c-downbtn">
                        <option value="default">默认</option>
                        <option value="bd">百度</option>
                        <option value="ty">天翼</option>
                        <option value="ct">诚通</option>
                        <option value="lz">蓝奏</option>
                        <option value="360">360</option>
                        <option value="wy">微云</option>
                        <option value="github">Github</option>

                    </select>
                </div>
                <button class="add-shortcode-btn el-button el-button--default el-button--small corepress-edit-window-btn"
                        shortcode="c-downbtn">插入下载面板
                </button>
            </div>

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
        <script>
            $('.add-shortcode-btn').click(function () {
                var shortcodename = $(this).attr('shortcode');
                if (shortcodename == 'title-plane') {
                    addshortcode('title-plane')
                } else if (shortcodename == 'icon-url') {
                    addshortcode('icon-url')
                } else if (shortcodename == 'zd-plane') {
                    addshortcode('zd-plane')
                } else if (shortcodename == 'clickshow') {
                    addshortcode('clickshow')
                } else if (shortcodename == 'loginshow') {
                    addshortcode('loginshow')
                } else if (shortcodename == 'pwdshow') {
                    addshortcode('pwdshow')
                } else if (shortcodename == 'start-plane') {
                    $type = $('.select-start-plane option:selected').val();
                    addshortcode('start-plane', $type);
                } else if (shortcodename == 'c-alert') {
                    $type = $('.select-c-alert option:selected').val();
                    addshortcode('c-alert', $type)
                } else if (shortcodename == 'c-downbtn') {
                    $type = $('.select-c-downbtn option:selected').val();
                    addshortcode('c-downbtn', $type)

                }
            })
        </script>
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


function corepress_mailtest()
{
    global $set;
    $set['testmail']['user'] = $_POST['user'];
    $set['testmail']['pwd'] = $_POST['pwd'];
    $set['testmail']['host'] = $_POST['host'];
    $set['testmail']['port'] = $_POST['port'];
    $set['testmail']['name'] = $_POST['name'];
    $set['testmail']['type'] = $_POST['type'];
    $set['testmail']['testmail'] = $_POST['testmail'];
    add_action('phpmailer_init', 'corepress_mail_test', 10);
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $mailre = wp_mail($set['testmail']['testmail'], 'CorePress主题测试邮件', '这是一封测试邮件，如果你看到这一条邮件，说明主题的SMTP服务器配置成功', $headers);
    remove_action('phpmailer_init', 'corepress_mail_test', 10);
    if ($mailre == 1) {
        $data['code'] = 200;
        $data['msg'] = '发送成功';
    } else {
        $data['code'] = 500;
        $data['msg'] = '发送失败';
    }
    wp_die(json_encode($data));
}

function corepress_mail_test($phpmailer)
{
    global $set;
    $phpmailer->From = $set['testmail']['user']; //发件人邮箱
    $phpmailer->FromName = $set['testmail']['name']; //发件人昵称
    $phpmailer->Host = $set['testmail']['host']; //SMTP服务器地址
    $phpmailer->Port = $set['testmail']['port']; //SMTP端口，常用端口有25、465、587
    $phpmailer->SMTPSecure = $set['testmail']['type']; //SMTP加密方式，常用的有SSL/TLS
    $phpmailer->Username = $set['testmail']['user']; //邮箱帐号
    $phpmailer->Password = $set['testmail']['pwd']; //邮箱密码。如果上面是qq邮箱这里就是QQ邮箱授权码。
    $phpmailer->IsSMTP(); //使用SMTP发送
    $phpmailer->SMTPAuth = true; //启用SMTPAuth服务
}

function corepress_approveuser()
{
    if (islogin()) {
        corepress_jmp_message('你已经登录！即将跳转首页...', get_bloginfo('url'));
        wp_die();
    } else {
        if (isset($_GET['key']) && $_GET['id']) {
            $key = $_GET['key'];
            $userid = $_GET['id'];
            if (get_user_meta($userid, 'corepress_approve', true) == 1) {
                $userObj = get_user_by('ID', $userid);
                $activation_key = $userObj->user_activation_key;
                if ($activation_key != null && strpos($activation_key, ":") == true) {
                    $arr = explode(":", $activation_key);
                    $time = $arr[0];
                    $activation_key = $arr[1];
                    $nowtime = time();
                    if ($nowtime - $time > 86400 || $nowtime - $time < -86400) {
                        wp_die('激活过期，请重新注册');
                    } else {
                        if ($key == $activation_key) {
                            update_user_meta($userid, 'corepress_approve', 0);
                            corepress_jmp_message('激活成功！请登陆账号,即将跳转登录页...', wp_login_url());
                            wp_die();
                        } else {
                            corepress_jmp_message('激活错误！即将跳转首页...', get_bloginfo('url'));
                            wp_die('激活错误');
                        }
                    }
                }

            } else {
                corepress_jmp_message('正常账户，请登陆，即将跳转登录页...', wp_login_url());
            }
        }
    }
}

function CorePress_lostpass()
{
    if (islogin()) {
        ajax_die('你已经登录');
    } else {
        session_start();
        if (isset($_POST['key']) && $_POST['user']) {
            $code = $_POST['key'];
            $user = $_POST['user'];
            if (strtoupper($code) != $_SESSION['authcode']) {
                ajax_die('验证码错误');

            } else {
                if (strpos($user, '@')) { //判断用户提交的是邮件还是用户名
                    $user_data = get_user_by_email($user); //通过Email获取用户数据
                    if (empty($user_data)) {
                        ajax_die('此邮箱无效');
                    } else {
                        if (reset_user_password($user_data) == 1) {
                            ajax_die('已经发送一封重置密码链接到您的邮箱', 1);
                        }

                    }
                } else {

                    $user_data = get_user_by('login', $user); //通过用户名获取用户数据
                    if (empty($user_data) || $user_data->caps['administrator'] == 1) { //排除管理员
                        ajax_die('用户名无效');
                    } else {
                        if (reset_user_password($user_data) == 1) {
                            ajax_die('已经发送一封重置密码链接到您的邮箱', 1);
                        }
                    }

                }
                ajax_die('发送邮件失败');
            }
        } else {
            wp_die('非法访问');
        }

    }

}

function CorePress_resetpwd()
{
    if (isset($_POST['key']) && isset($_POST['pwd']) && isset($_POST['userid'])) {
        $userid = $_POST['userid'];
        $key = $_POST['key'];
        $pwd = $_POST['pwd'];
        $userObj = get_user_by('ID', $userid);
        $activation_key = $userObj->user_activation_key;
        if ($activation_key != null && strpos($activation_key, ":") == true) {
            $arr = explode(":", $activation_key);
            $time = $arr[0];
            $activation_key = $arr[1];
            $nowtime = time();
            if ($nowtime - $time > 86400 || $nowtime - $time < -86400) {
                ajax_die('验证过期');
            } else {
                if ($key == $activation_key) {

                    $userdata = array(
                        'ID' => $userid,
                        'user_pass' => $pwd
                    );
                    $id = wp_update_user($userdata);
                    if ($id == $userid) {
                        $json['code'] = 1;
                        $json['msg'] = '已成功重置密码，请重新登录';
                        wp_die(json_encode($json));
                    } else {
                        ajax_die('未知错误');
                    }

                } else {
                    ajax_die('验证失败');

                }
            }

        } else {
            ajax_die('验证失败');

        }

    } else {
        ajax_die('参数错误');

    }
}

function CorePress_updateUserInfo()
{
    if (isset($_POST['user']) && isset($_POST['description'])) {
        $user = $_POST['user'];
        $description = $_POST['description'];
        $currentUser = wp_get_current_user();
        wp_update_user(array('ID' => $currentUser->ID, 'display_name' => $user));
        update_user_meta($currentUser->ID, 'description', $description);
        ajax_die('更新成功', 1);

    } else {
        ajax_die('参数错误');

    }
}

function CorePress_getpwdmailcode()
{
    session_start();
    $time = time();

    if (!isset($_POST['type'])) {
        ajax_die('参数错误');
    }
    $type = $_POST['type'];
    $currentUser = wp_get_current_user();
    $key = md5($time);
    $key = substr($key, -4);

    if ($type == 'changepwd') {
        $session_name = 'time_changepwd';
        if (isset($_SESSION[$session_name]) && $time - $_SESSION[$session_name] < 60) {
            ajax_die('发送频繁，请稍后再试');

        }

        $_SESSION['pwdmailcode'] = $key;
        $mail = $currentUser->user_email;
        $mail_content = '您好，您在本网站进行修改密码操作，你的验证码为：<span style="color: red">' . $key . '</span>【本验证码30分钟内有效，如果不是您的操作，请忽略】<br>';
        $mail_title = '[修改密码验证码]';

    } elseif ($type == 'changemail') {
        $session_name = 'time_changemail';
        if (isset($_SESSION[$session_name]) && $time - $_SESSION[$session_name] < 60) {
            ajax_die('发送频繁，请稍后再试');

        }

        $_SESSION['changemailcode'] = $key;
        $mail = $currentUser->user_email;
        $mail_content = '您好，您在本网站进行更换邮箱操作，你的验证码为：<span style="color: red">' . $key . '</span>【本验证码30分钟内有效，如果不是您的操作，请忽略】<br>';
        $mail_title = '[更换邮箱验证码]';


    } elseif ($type == 'bindemail') {
        $re_arry = parameter_verification(array('oldcode', 'mail'), 1);
        $session_name = 'time_bindemail';
        if (isset($_SESSION[$session_name]) && $time - $_SESSION[$session_name] < 60) {
            ajax_die('发送频繁，请稍后再试');
        }
        $oldcode = $_POST['oldcode'];
        if ($time - $_SESSION['time_changemail'] > 1800) {
            ajax_die('原始邮箱验证码超时');
        }

        if ($oldcode != $_SESSION['changemailcode']) {
            ajax_die('原始邮箱验证码错误');
        }

        $_SESSION['bindemailcode'] = $key;
        $mail = $_POST['mail'];
        $_SESSION['bindemail'] = $mail;
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            ajax_die('邮箱格式错误');
        }
        if (email_exists($mail)) {
            ajax_die('邮箱已经被绑定');
        }
        $mail_content = '您好，您在本网站进行绑定邮箱操作，你的验证码为：<span style="color: red">' . $key . '</span>【本验证码30分钟内有效，如果不是您的操作，请忽略】<br>';
        $mail_title = '[绑定邮箱验证码]';
    } else {
        ajax_die('参数错误');
    }
    $_SESSION[$session_name] = $time;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $mailre = wp_mail($mail, get_option('blogname', '【CorePress】') . $mail_title, $mail_content, $headers);
    if ($mailre == 1) {
        ajax_die('发送成功', 1);

    } else {
        ajax_die('发送失败');
    }
}

function CorePress_changepwd()
{
    session_start();
    $time = time();
    if (!isset($_POST['oldpwd']) || !isset($_POST['newpwd']) || !isset($_POST['mailcode'])) {
        $json['code'] = 0;
        $json['msg'] = '参数错误';
        wp_die(json_encode($json));
    }
    $oldpwd = $_POST['oldpwd'];
    $newpwd = $_POST['newpwd'];
    $mailcode = $_POST['mailcode'];
    if (isset($_SESSION['pwdmailcodesendtime']) && $time - $_SESSION['pwdmailcodesendtime'] < 1800) {
        if ($_SESSION['pwdmailcode'] != $mailcode) {
            $json['code'] = 0;
            $json['msg'] = '验证码错误';
            wp_die(json_encode($json));
        }
        $currentUser = wp_get_current_user();

        if (!wp_check_password($oldpwd, $currentUser->user_pass)) {
            $json['code'] = 0;
            $json['msg'] = '旧密码错误';
            wp_die(json_encode($json));
        } else {

            if (!ctype_alnum($newpwd) || strlen($newpwd) < 8 || preg_match("/([\x81-\xfe][\x40-\xfe])/", $newpwd, $match) == true) {
                $json['code'] = 0;
                $json['msg'] = '密码不符合要求';
                wp_die(json_encode($json));
            }

            wp_update_user(array('ID' => $currentUser->ID, 'user_pass' => $newpwd));
            $json['code'] = 1;
            $json['msg'] = '密码修改成功！';
            $_SESSION['pwdmailcode'] = '';
            $_SESSION['pwdmailcodesendtime'] = 0;
            wp_die(json_encode($json));
        }

    } else {
        $json['code'] = 0;
        $json['msg'] = '验证码超时';
        wp_die(json_encode($json));
    }
}

function CorePress_changebind()
{
    session_start();
    $re_arry = parameter_verification(array('old_mail_code', 'new_mail_code', 'bind_mail', 'type'), 1);
    if ($re_arry['type'] == 'bindemail') {
        $time = time();
        $changemailcode = $_SESSION['changemailcode'];

        $changemailcode_time = $_SESSION['time_changemail'];
        $bindemailcode = $_SESSION['bindemailcode'];
        $bindemailcode_time = $_SESSION['time_bindemail'];
        $bind_mail = $re_arry['bind_mail'];
        if ($time - $changemailcode_time > 1800) {
            ajax_die('原始邮箱验证码超时' . $changemailcode_time);
        }
        if ($time - $bindemailcode_time > 1800) {
            ajax_die('新邮箱验证码超时');
        }
        if ($changemailcode != $re_arry['old_mail_code'] || $_SESSION['bindemail'] != $bind_mail) {
            ajax_die('原始邮箱验证码错误');
        }
        if ($bindemailcode != $re_arry['new_mail_code']) {
            ajax_die('新邮箱验证码错误');
        }

        $currentUser = wp_get_current_user();
        wp_update_user(array('ID' => $currentUser->ID, 'user_email' => $bind_mail));
        ajax_die('更换邮箱成功！', 1);
        $_SESSION['bindemailcode'] = null;
        $_SESSION['changemailcode'] = null;

    } else {
        ajax_die('类型错误');
    }
}

function corepress_getfirstspell()
{
    $text = replace_symbol($_POST['text']);
    $json['code'] = 1;
    $json['data'] = corepress_pinyin_long($text);
    wp_die(json_encode($json));
}

add_action('wp_ajax_corepress_getfirstspell', 'corepress_getfirstspell');

add_action('wp_ajax_corepress_changebind', 'CorePress_changebind');
add_action('wp_ajax_corepress_changepwd', 'CorePress_changepwd');
add_action('wp_ajax_corepress_getpwdmailcode', 'CorePress_getpwdmailcode');

add_action('wp_ajax_corepress_updateuserinfo', 'CorePress_updateUserInfo');

add_action('wp_ajax_nopriv_corepress_resetpwd', 'CorePress_resetpwd');
add_action('wp_ajax_corepress_resetpwd', 'CorePress_resetpwd');


add_action('wp_ajax_nopriv_corepress_lostpass', 'CorePress_lostpass');
add_action('wp_ajax_corepress_lostpass', 'CorePress_lostpass');

add_action('wp_ajax_corepress_approveuser', 'corepress_approveuser');
add_action('wp_ajax_nopriv_corepress_approveuser', 'corepress_approveuser');
add_action('wp_ajax_corepress_mailtest', 'corepress_mailtest');
add_action('wp_ajax_nopriv_resetuser', 'corepress_resetuser');
add_action('wp_ajax_nopriv_corepress_login', 'CorePress_login');
add_action('wp_ajax_nopriv_corepress_reguser', 'CorePress_reguser');
add_action('wp_ajax_corepress_reguser', 'CorePress_reguser');

add_action('wp_ajax_save', 'CorePress_saveThemeset');//管理员调用
add_action('wp_ajax_geteditwindowhtml', 'CorePress_edit_window_html');//管理员调用
add_action('save_post', 'corepress_save_post_meta');

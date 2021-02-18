<?php
add_filter('pre_get_users', 'corepress_filter_users');

function corepress_filter_users($query)
{
    global $pagenow;
    if (is_admin() && 'users.php' == $pagenow) {
        global $wpdb;
        if (!isset($_GET['orderby'])) {
            $query->set('orderby', 'registered');
            $query->set('order', 'desc');
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status'] == 'unapproved') {
            $query->set('meta_query', array(
                array(
                    'key' => 'corepress_approve',
                    'value' => '1',
                    'compare' => '='
                )
            ));
        }
    }
    return $query;
}

function filter_users_by_groups($query)
{
    global $pagenow;
    if (is_admin() && 'users.php' == $pagenow && (isset($_REQUEST['filter_btn']) || isset($_REQUEST['filter_btn2']))) {
        $filter_group = isset($_REQUEST['filter_btn']) ? $_REQUEST['filter_group'] : $_REQUEST['filter_group2'];
        $group = get_term_by('slug', $filter_group, 'user-groups');
        $users = get_objects_in_term($group->term_id, 'user-groups');
        $query->set('include', $users);
    }
}

function corepress_views_users($views)
{
    global $wpdb;
    if (!current_user_can('edit_users')) return $views;
    $current = '';
    if (isset($_REQUEST['status']) && $_REQUEST['status'] == 'unapproved') $current = 'class="current"';
    $meta_key = 'corepress_approve';
    $users = get_users(array(
        'meta_query' => array(
            array(
                'key' => $meta_key,
                'value' => '1',
                'compare' => '='
            )
        )
    ));
    $count = count($users);
    $views['unapproved'] = '<a href="' . admin_url('users.php') . '?status=unapproved" ' . $current . '>' . '待审核' . ' <span class="count">（' . $count . '）</span></a>';
    return $views;
}


add_filter('bulk_actions-users', 'corepress_add_userlist_approve');
function corepress_add_userlist_approve($actions)
{
    if (current_user_can('edit_users')) {
        $actions['approve'] = '审核用户';
        $actions['disapprove'] = '设置为未审核';
    }
    return $actions;
}

add_filter('handle_bulk_actions-users', 'corepress_handle_users', 10, 3);
function corepress_handle_users($redirect_to, $doaction, $ids)
{
    if (!$ids || !current_user_can('edit_users')) return $redirect_to;
    if ($doaction == 'approve') {
        foreach ($ids as $id) {
            update_user_meta($id, 'corepress_approve', 0);
        }
    } else if ($doaction == 'disapprove') {

        foreach ($ids as $id) {
            if (user_can($id, 'edit_users')) {
                continue;
            }
            update_user_meta($id, 'corepress_approve', 1);
        }
    }
    return $redirect_to;
}


function corepress_user_row_action($actions, $user)
{
    if (isset($_GET['status']) && $_GET['status'] == 'unapproved') {
        if (current_user_can('edit_users')) {
            $actions['approveone'] = '<a title="审核用户" href="' . admin_url("users.php?&action=approve&amp;users[]=$user->ID") . '">审核用户</a>';
        }
    }
    return $actions;
}

add_filter('user_row_actions', 'corepress_user_row_action', 10, 2);
add_action('user_register', 'corepress_user_register');
function corepress_user_register($id)
{
    global $set, $wpdb;
    if ($set['user']['regapproved'] == 'manualapprov') {
        update_user_meta($id, 'corepress_approve', 1);
    }
    $time = time();
    $key = md5($time);
    $wpdb->update($wpdb->users, array('user_activation_key' => $time . ':' . $key), array('ID' => $id));

    if ($set['user']['regapproved'] == 'mailapproved') {
        update_user_meta($id, 'corepress_approve', 1);
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $userobj = get_user_by('ID', $id);
        $mailre = wp_mail($userobj->user_email, get_option('blogname', '【CorePress】') . '激活用户验证', '您好，感谢注册本站用户，下面是您的激活链接，点击访问即可激活用户，激活以后可以正常登陆账号。【激活链接24小时内容有效】<br>' .
            admin_url('admin-ajax.php') . '?action=corepress_approveuser&key=' . $key . '&id=' . $id, $headers);
    }
}

add_action('wp_login', 'corepress_action_login', 10, 2);
function corepress_action_login($user_login, $user)
{
    global $set;

    if (get_user_meta($user->ID, 'corepress_approve', true) == 1) {
        $json['code'] = 0;
        $json['msg'] = '登录失败，账号未通过审核';
        wp_logout();
        wp_die(json_encode($json));
    }
}

function corepress_mail_smtp($phpmailer)
{
    global $set;
    $phpmailer->From = $set['module']['smtpuser']; //发件人邮箱
    $phpmailer->FromName = $set['module']['smtpname']; //发件人昵称
    $phpmailer->Host = $set['module']['smtphost']; //SMTP服务器地址
    $phpmailer->Port = $set['module']['smtpport']; //SMTP端口，常用端口有25、465、587
    $phpmailer->SMTPSecure = $set['module']['smtpencrypttype']; //SMTP加密方式，常用的有SSL/TLS
    $phpmailer->Username = $set['module']['smtpuser']; //邮箱帐号
    $phpmailer->Password = $set['module']['smtppwd']; //邮箱密码。如果上面是qq邮箱这里就是QQ邮箱授权码。
    $phpmailer->IsSMTP(); //使用SMTP发送
    $phpmailer->SMTPAuth = true; //启用SMTPAuth服务
}

global $set;
if ($set['module']['smtp'] == 1) {
    add_action('phpmailer_init', 'corepress_mail_smtp', 10);
}

function reset_user_password($userobj)
{
    global $set, $wpdb;
    $time = time();
    $key = md5($time);
    $wpdb->update($wpdb->users, array('user_activation_key' => $time . ':' . $key), array('ID' => $userobj->ID));
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $mailre = wp_mail($userobj->user_email, get_option('blogname', '【CorePress】') . '重置密码验证', '您好，您在本网站进行重置密码操作，请点击如下链接进入重置密码页面。【本链接24小时内容有效，如果不是您的操作，请忽略】<br>' .
        '<a target="_blank" href="' . $set['user']['repasswordurl'] . '?action=resetpwd&key=' . $key . '&id=' . $userobj->ID . '">' . $set['user']['repasswordurl'] . '?action=resetpwd&key=' . $key . '&id=' . $userobj->ID . '</a>', $headers);
    return $mailre;
}

function showlostpasshtml($type, $msg)
{

    if ($type == 1) {
        ?>
        <div id="login-plane">
            <div class="login-main" style="width: 100%;">
                <div id="login-note">
                    提示
                </div>
                <div class="login-form">
                    <div class="login-title"><h3>重置密码</h3></div>
                    <i class="fas fa-key ico-login" aria-hidden="true"></i>
                    <input class="input-login input-pass"
                           name="pwd"
                           type="password"
                           placeholder="请输入新密码">
                    <div>
                        <i class="fas fa-key ico-login" aria-hidden="true"></i>
                        <input class="input-login input-pass"
                               name="repwd"
                               type="password"
                               placeholder="重复密码">

                        <button class="login-button" id="btn-resetpwd">重置密码</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div id="login-plane">
            <div class="login-main" style="width: 100%;">
                <div class="login-form">
                    <div class="login-title">
                        <div>
                            <h3>验证提示</h3>
                            <div>
                                <br><br>
                                <?php echo $msg ?>
                                <a href="<?php echo bloginfo('url'); ?>">点此回首页</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

function showresetpwdhtml(){
    ?>
    <div id="login-plane">
        <div class="login-main" style="width: 100%;">
            <div id="login-note">
                提示
            </div>
            <div class="login-form">
                <div class="login-title"><h3>找回密码</h3>

                </div>

                <i class="fa fa-user ico-login" aria-hidden="true"></i><input class="input-login input-pass"
                                                                              name="user"
                                                                              type="text"
                                                                              placeholder="请输入用户名或者邮箱">
                <div class="code-plane"><img class="img-code"
                                             src="<?php echo FRAMEWORK_URI . "/VerificationCode.php" ?>"
                                             alt=""><input class="input-login input-code"
                                                           name="code"
                                                           type="text"
                                                           placeholder="验证码"></div>
                <div>
                    <button class="login-button" id="btn-getlostpass">找回密码</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}

<?php
// TEMPLATE NAME: CorrPress自定义登录页面
if (islogin()) {
    header("Location: /");
    exit();
}
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
    <?php echo get_bloginfo('siteurl') ?>
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

    <style>
        <?php
if ($set['user']['lgoinpageimg'] != null) {
    echo '#app{background-image:url('.$set['user']['lgoinpageimg'].');}';
}
?>
    </style>
    <main class="container">
        <div id="login-plane">
            <div class="login-main">
                <div id="login-note">
                    提示
                </div>
                <div class="login-form">
                    <div class="login-title"><h3>登录账户</h3>
                        <?php if (get_option('users_can_register')) {
                            echo '<span><a href="' . wp_registration_url() . '">注册用户</a></span>';
                        } ?>
                    </div>
                    <i class="fa fa-user ico-login" aria-hidden="true"></i><input class="input-login input-user"
                                                                                  name="user"
                                                                                  type="text"
                                                                                  placeholder="请输入用户名/电子邮箱">
                    <i class="fa fa-key ico-login" aria-hidden="true"></i><input class="input-login input-pass"
                                                                                 name="pass"
                                                                                 type="password"
                                                                                 placeholder="请输入密码">
                    <?php
                    if ($set['user']['VerificationCode'] == 1) {
                        ?>
                        <div class="code-plane"><img class="img-code"
                                                     src="<?php echo FRAMEWORK_URI . "/VerificationCode.php" ?>"
                                                     alt=""><input class="input-login input-code"
                                                                   name="code"
                                                                   type="text"
                                                                   placeholder="验证码"></div>
                        <?php
                    }
                    ?>
                    <div class="login-title">
                        <label><input type="checkbox" id="remember" name="remember" value="true">记住我的登录状态</label>
                        <a href="<?php echo wp_lostpassword_url() ?>">忘记密码?</a>
                    </div>
                    <div>
                        <button class="login-button" id="btn-login">登录</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $('.img-code').click(() => {
            recodeimg();
        });
        $('#btn-login').click(() => {
            var user = $('input[name="user"]').val();
            var pass = $('input[name="pass"]').val();
            var code = $('input[name="code"]').val();
            if (user == '' || pass == '') {
                return;
            }
            var remember = $('#remember').val();
            $('#login-note').text('登录中，请稍后');
            $('#login-note').css('visibility', 'visible');
            $.post('<?php echo AJAX_URL?>', {
                action: 'corepress_login',
                user: user,
                pass: pass,
                remember: remember,
                code: code
            }, (data) => {
                var obj = JSON.parse(data);
                if (obj) {
                    if (obj.code === 1) {
                        $('#login-note').text('登录成功，跳转中');
                        window.location.href = getQueryVariable('re') ? getQueryVariable('re') : '/';
                    } else {
                        $('#login-note').text(obj.msg);
                        recodeimg();
                    }
                } else {

                }
            })
        })

        function recodeimg() {
            $('.img-code').attr('src', '<?php echo FRAMEWORK_URI . "/VerificationCode.php?t=" . time() ?>');
        }
    </script>
    <footer>
        <?php
        wp_footer();
        get_footer(); ?>
    </footer>
</div>
</body>
</html>


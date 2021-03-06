<?php
// TEMPLATE NAME: CorrPress自定义注册页面
if (islogin()) {
    header("Location: " . get_bloginfo('url'));
    exit();
}
if (!get_option('users_can_register')) {
    header("Location: " . get_bloginfo('url'));
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
if ($set['user']['regpageimg'] != null) {
    echo '#app{background-image:url('.$set['user']['regpageimg'].');}';
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
                    <div class="login-title"><h3>注册用户</h3></div>
                    <i class="fas fa-user ico-login" aria-hidden="true"></i><input class="input-login input-user"
                                                                                   name="user"
                                                                                   type="text"

                                                                                   placeholder="用户名(只能英文)">
                    <i class="far fa-envelope ico-login" aria-hidden="true"></i><input class="input-login input-pass"
                                                                                       name="mail"
                                                                                       type="text"

                                                                                       placeholder="电子邮箱">

                    <i class="fas fa-key ico-login" aria-hidden="true"></i><input class="input-login input-pass"
                                                                                  name="pass"
                                                                                  type="text"

                                                                                  placeholder="密码">
                    <i class="fas fa-key ico-login" aria-hidden="true"></i><input
                            class="input-login input-pass"
                            name="repass"
                            type="text"

                            placeholder="重复密码">
                    <?php
                    if ($set['user']['regpageVerificationCode'] == 1) {
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
                        <div>已有账户?</div>
                        <a href="<?php echo wp_login_url() ?>">立即登录</a>
                    </div>
                    <div>
                        <button class="login-button" id="btn-login">注册账户</button>
                    </div>
                    <div class="usercenter-info-text">
                        <p><b>注册须知：</b></p>
                        <p>用户名只支持英文用户名</p>
                        <p>密码不能包含中文，长度8位以上，并且必须包含中英文和数字</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $('.img-code').click(() => {
            recodeimg();
        });

        function recodeimg() {
            $('.img-code').attr('src', '<?php echo FRAMEWORK_URI . "/VerificationCode.php?t=" . time() ?>');
        }

        $('input[name="repass"],input[name="user"],input[name="mail"]').click(function () {
            $(this).removeClass('input-warning');
        });
        $('#btn-login').click(() => {
            var user = $('input[name="user"]').val();
            var mail = $('input[name="mail"]').val();
            var pass = $('input[name="pass"]').val();
            var repass = $('input[name="repass"]').val();
            var code = $('input[name="code"]').val();
            if (pass != repass) {
                $('input[name="repass"]').addClass('input-warning')
                $('#login-note').text('两次密码输入不一致');
                $('#login-note').css('visibility', 'visible');
                setTimeout(function () {
                    $('#login-note').css('visibility', 'hidden');
                }, 3000);
                return;
            }
            if (user == '' || pass == '' || repass == '' || mail == '') {
                return;
            }
            if (!checkEmail(mail)) {
                $('#login-note').text('邮箱格式不正确');
                $('#login-note').css('visibility', 'visible');
                $('input[name="mail"]').addClass('input-warning')
                setTimeout(function () {
                    $('#login-note').css('visibility', 'hidden');
                }, 3000);
                return;
            }

            if (isChinese(pass) || isChinese(user)) {
                addarelt('密码和用户名不支持中文', 'erro');
                return;
            }
            if (!haveNumandLetter(pass)) {
                addarelt('密码必须包含字母和数字', 'erro');
                return;
            }
            if (pass.length < 8) {
                addarelt('密码必须大于8位', 'erro');
                return;
            }


            $('#login-note').text('正在注册，请稍后');
            $('#login-note').css('visibility', 'visible');
            $.post('<?php echo AJAX_URL?>', {
                action: 'corepress_reguser',
                user: user,
                mail: mail,
                pass: pass,
                code: code
            }, (data) => {
                var obj = JSON.parse(data);
                if (obj) {
                    if (obj.code === 1) {
                        $('#login-note').text('注册成功，跳转登陆页面');
                        window.location.href = '<?php echo wp_login_url()?>';
                    } else if (obj.code === 2) {
                        $('#login-note').text(obj.msg);
                    } else if (obj.code === 0) {
                        $('#login-note').text(obj.msg);
                        recodeimg();
                    }
                }
            });
        });

        function checkEmail(email) {
            var myreg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
            if (!myreg.test(email)) {
                return false;
            } else {
                return true;
            }
        }
    </script>
    <footer>
        <?php

        get_footer(); ?>
    </footer>
</div>
</body>
</html>

